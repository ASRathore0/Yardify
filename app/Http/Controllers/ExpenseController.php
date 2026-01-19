<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseGroup;
use App\Models\Expense;
use App\Models\ExpenseShare;
use App\Models\Invitation;
use App\Models\User;
use App\Models\Settlement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    // Show expense management UI
    public function index(Request $request)
    {
        $user = auth()->user();
        $groups = collect();
        $group = null;

        if ($user) {
            $identifiers = [];
            if (!empty($user->name)) $identifiers[] = $user->name;
            if (!empty($user->email)) $identifiers[] = $user->email;

            // fetch groups where the user is creator or listed in members
            // include trashed groups so members can see deleted groups
            $query = ExpenseGroup::withTrashed()->with(['expenses.shares']);
            $query->where(function($q) use ($identifiers, $user){
                $q->where('created_by', $user->id);
                foreach ($identifiers as $id) {
                    $q->orWhereJsonContains('members', $id);
                }
            });

            $all = $query->get();
            // Owners who deleted their group should not see it in their own list.
            $visible = $all->filter(function($g) use ($user) {
                if ($g->deleted_at && $g->created_by == $user->id) return false;
                return true;
            });

            $groups = $visible->map(function($g){
                return [
                    'id' => $g->id,
                    'name' => $g->name,
                    'created_by' => $g->created_by,
                    'currency' => $g->currency,
                    'members' => $this->normalizeMembers($g->members ?? []),
                    'deleted' => $g->deleted_at ? true : false,
                    'deleted_at' => $g->deleted_at ? $g->deleted_at->toDateTimeString() : null,
                    'expenses' => $g->deleted_at ? [] : $g->expenses->map(function($e){
                        $shares = [];
                        foreach ($e->shares as $s) {
                            $shares[$s->member] = (float)$s->amount;
                        }
                        return [
                            'id' => 'e'.$e->id,
                            'title' => $e->title ?? ($e->note ?? 'Expense'),
                            'amount' => (float)$e->amount,
                            'paid_by' => $e->payer_name ?? $e->payer_id,
                            'category' => $e->category,
                            'split_method' => $e->split_method,
                            'shares' => $shares,
                            'created_at' => optional($e->spent_at)->toDateTimeString() ?? $e->created_at->toDateTimeString(),
                        ];
                    })->toArray(),
                ];
            })->toArray();

            $selected = $request->query('group');
            if ($selected) {
                $found = collect($groups)->firstWhere('id', (int)$selected);
                    if ($found) {
                    $group = $found;
                    $members = $group['members'];
                    $balances = array_fill_keys($members, 0.0);
                    foreach ($group['expenses'] as $e) {
                        foreach ($e['shares'] as $m => $amt) {
                            $mapped = $this->mapShareKey($m, $members);
                            if (!isset($balances[$mapped])) $balances[$mapped] = 0.0;
                            $balances[$mapped] -= $amt;
                        }
                        $payer = $this->mapShareKey($e['paid_by'], $members);
                        if (!isset($balances[$payer])) $balances[$payer] = 0.0;
                        $balances[$payer] += $e['amount'];
                    }
                    $group['balances'] = $balances;
                }
            }
        }

        return view('expense.index', compact('groups','group'));
    }

    // Show form to create group (separate page)
    public function create()
    {
        return view('expense.create');
    }

    // Show a single group's dashboard page
    public function show(Request $request, $group)
    {
        $g = ExpenseGroup::with(['expenses.shares'])->find($group);
        if (!$g) abort(404);

        $user = auth()->user();
        $allowed = false;
        if ($user) {
            $identifiers = [];
            if (!empty($user->name)) $identifiers[] = $user->name;
            if (!empty($user->email)) $identifiers[] = $user->email;
            if ($g->created_by == $user->id) $allowed = true;
            foreach ($identifiers as $id) {
                if (in_array($id, $g->members ?? [])) { $allowed = true; break; }
            }
        }

        if (!$allowed) abort(403);

        $group = [
            'id' => $g->id,
            'name' => $g->name,
            'currency' => $g->currency,
            'members' => $this->normalizeMembers($g->members ?? []),
            'expenses' => [],
        ];

        // Build a combined list of expenses and settlements, then sort by created_at desc
        $items = [];
        foreach ($g->expenses as $e) {
            $shares = [];
            foreach ($e->shares as $s) {
                $shares[$s->member] = (float)$s->amount;
            }
            $items[] = [
                'id' => 'e'.$e->id,
                'title' => $e->title ?? ($e->note ?? 'Expense'),
                'amount' => (float)$e->amount,
                'paid_by' => $e->payer_name ?? $e->payer_id,
                'category' => $e->category,
                'split_method' => $e->split_method,
                'shares' => $shares,
                'created_at' => optional($e->spent_at)->toDateTimeString() ?? $e->created_at->toDateTimeString(),
            ];
        }

        // compute balances using only expenses that occurred after the latest settlement
        $members = $group['members'];
        $balances = array_fill_keys($members, 0.0);
        $lastSettlement = Settlement::where('group_id', $g->id)->orderBy('created_at', 'desc')->first();
        foreach ($g->expenses as $e) {
            // if there's a last settlement, only include expenses after it
            if ($lastSettlement && $e->created_at <= $lastSettlement->created_at) continue;
            foreach ($e->shares as $s) {
                $m = $s->member;
                $amt = (float)$s->amount;
                $mapped = $this->mapShareKey($m, $members);
                if (!isset($balances[$mapped])) $balances[$mapped] = 0.0;
                $balances[$mapped] -= $amt;
            }
            $payer = $this->mapShareKey($e->payer_name ?? $e->payer_id, $members);
            if (!isset($balances[$payer])) $balances[$payer] = 0.0;
            $balances[$payer] += (float)$e->amount;
        }
        $group['balances'] = $balances;

        // compute total amount paid (spent) by each member, only post-last-settlement
        $totals = array_fill_keys($members, 0.0);
        foreach ($g->expenses as $e) {
            if ($lastSettlement && $e->created_at <= $lastSettlement->created_at) continue;
            $payer = $this->mapShareKey($e->payer_name ?? $e->payer_id, $members);
            if (!isset($totals[$payer])) $totals[$payer] = 0.0;
            $totals[$payer] += (float)$e->amount;
        }
        $group['totals_paid'] = $totals;

        // Include settlement entries in the expense history (as special items)
        $settlements = Settlement::where('group_id', $g->id)->get();
        foreach ($settlements as $s) {
            $items[] = [
                'id' => 's'.$s->id,
                'title' => 'Group settlement',
                'amount' => (float)$s->total_amount,
                'paid_by' => 'Settled',
                'category' => 'Settled',
                'split_method' => 'settlement',
                'shares' => $s->snapshot ?? [],
                'created_at' => $s->created_at->toDateTimeString(),
            ];
        }

        // sort items by created_at desc (newest first)
        usort($items, function($a, $b){
            return strtotime($b['created_at']) <=> strtotime($a['created_at']);
        });

        // Pagination
        $perPage = request()->input('per_page', 20);
        if (!in_array($perPage, [10, 20, 40, 50])) $perPage = 20;

        $page = request()->input('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $pagedItems = array_slice($items, $offset, $perPage);
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedItems,
            count($items),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $group['expenses'] = $paginator;

        return view('expense.show', ['group' => $group]);
    }

    // Create a group (session-backed demo)
    public function storeGroup(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500', 
            'members' => 'nullable|string', // comma separated emails/names
        ]);

        $members = array_values(array_filter(array_map('trim', explode(',', $data['members'] ?? ''))));
        $user = Auth::user();
        if (empty($members)) {
            if ($user) {
                $members = [$user->name ?: $user->email];
            } else {
                $members = ['You'];
            }
        } else {
            // ensure creator is present in members
            if ($user) {
                $creatorId = $user->name ?: $user->email;
                if (!in_array($creatorId, $members)) {
                    array_unshift($members, $creatorId);
                }
            }
        }

        $g = ExpenseGroup::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'members' => $members,
            'currency' => 'USD',
            'created_by' => Auth::check() ? Auth::id() : null,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'group' => [
                'id' => $g->id,
                'name' => $g->name,
                'members' => $this->normalizeMembers($g->members),
                'expenses' => [],
            ]]);
        }

        return redirect()->back()->with('success', 'Group created successfully');
    }

    // Add an expense to a group and compute balances
    public function storeExpense(Request $request, $group)
    {
        $rules = [
            'title' => 'required|string|max:200',
            'amount' => 'required|numeric|min:0',
            'paid_by' => 'required|string',
            'category' => 'required|string',
            'split_method' => 'required|string|in:equal,exact,percent',
            'exact_shares' => 'nullable',
            'percent_shares' => 'nullable',
            // If is_custom_split is set, we MUST have involve_members array with at least 1 item
            'involved_members' => 'required_if:is_custom_split,1|array|min:1',
        ];
        
        $data = $request->validate($rules);

        $g = ExpenseGroup::find($group);
        if (!$g) {
            return response()->json(['status' => 'error','message' => 'Group not found'], 404);
        }

        // Use normalized members (deduplicated, prefer registered names) so
        // shares are recorded against canonical display identifiers.
        $members = $this->normalizeMembers($g->members ?? []);

        // Filter involved members
        // If is_custom_split is present, use the array (validated above)
        // If NOT present (e.g. API or old form), assume ALL members
        $involved = $members;
        if ($request->has('is_custom_split')) {
             // We know involved_members is present and valid due to validation
             $involved = array_values(array_intersect($members, $request->involved_members));
        } elseif ($request->has('involved_members') && is_array($request->involved_members)) {
             // Backward compatibility just in case
             $involved = array_values(array_intersect($members, $request->involved_members));
        }

        $n = count($involved) ?: 1;

        $amount = (float)$data['amount'];

        // compute shares
        $shares = [];
        if ($data['split_method'] === 'equal') {
            $per = round($amount / $n, 2);
            foreach ($members as $m) {
                $shares[$m] = in_array($m, $involved) ? $per : 0;
            }
        } elseif ($data['split_method'] === 'exact') {
            $exact = $data['exact_shares'] ?? '';
            $map = $this->parseKeyValueString($exact, $members);
            // normalize any keys (emails -> names) to match canonical member list
            $normalizedMap = [];
            foreach ($map as $k => $v) {
                $key = $this->mapShareKey($k, $members);
                $normalizedMap[$key] = (float)$v;
            }
            foreach ($members as $m) $shares[$m] = isset($normalizedMap[$m]) ? (float)$normalizedMap[$m] : 0.0;
        } else { // percent
            $percent = $data['percent_shares'] ?? '';
            $map = $this->parseKeyValueString($percent, $members);
            $normalizedMap = [];
            foreach ($map as $k => $v) {
                $key = $this->mapShareKey($k, $members);
                $normalizedMap[$key] = (float)$v;
            }
            foreach ($members as $m) {
                $p = isset($normalizedMap[$m]) ? (float)$normalizedMap[$m] : 0;
                $shares[$m] = round($amount * $p / 100, 2);
            }
        }

        DB::transaction(function() use ($g, $data, $shares, $amount) {
            $expense = Expense::create([
                'group_id' => $g->id,
                'payer_name' => $data['paid_by'],
                'amount' => $amount,
                'currency' => $g->currency ?? 'USD',
                'split_method' => $data['split_method'],
                'splits' => $shares,
                'category' => $data['category'] ?? null,
                'note' => $data['title'] ?? null,
                'spent_at' => now(),
            ]);

            foreach ($shares as $member => $amt) {
                ExpenseShare::create([
                    'expense_id' => $expense->id,
                    'member' => $member,
                    'amount' => $amt,
                ]);
            }
        });

        // reload group for response
        $g = ExpenseGroup::with(['expenses.shares'])->find($g->id);
        $resp = [
            'id' => $g->id,
            'name' => $g->name,
            'members' => $this->normalizeMembers($g->members ?? []),
            'expenses' => [],
        ];
        foreach ($g->expenses as $e) {
            $sarr = [];
            foreach ($e->shares as $s) $sarr[$s->member] = (float)$s->amount;
            $resp['expenses'][] = [
                'id' => 'e'.$e->id,
                'title' => $e->note ?? 'Expense',
                'amount' => (float)$e->amount,
                'paid_by' => $e->payer_name ?? $e->payer_id,
                'category' => $e->category,
                'split_method' => $e->split_method,
                'shares' => $sarr,
                'created_at' => optional($e->spent_at)->toDateTimeString() ?? $e->created_at->toDateTimeString(),
            ];
        }

        // compute balances (map share keys to display members)
        $balances = [];
        foreach ($resp['members'] as $m) $balances[$m] = 0.0;
        foreach ($resp['expenses'] as $ex) {
            foreach ($ex['shares'] as $m => $amt) {
                $mapped = $this->mapShareKey($m, $resp['members']);
                if (!isset($balances[$mapped])) $balances[$mapped] = 0.0;
                $balances[$mapped] -= $amt;
            }
            $payer = $this->mapShareKey($ex['paid_by'], $resp['members']);
            if (!isset($balances[$payer])) $balances[$payer] = 0.0;
            $balances[$payer] += $ex['amount'];
        }
        $resp['balances'] = $balances;

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'success', 'group' => $resp]);
        }

        return redirect()->route('expense.groups.show', ['group' => $g->id]);
    }

    // Send invitations to group members (creates invitation records, optionally send email)
    public function invite(Request $request, $group)
    {
        // Create a reusable invite link (no email required)
        $g = ExpenseGroup::find($group);
        if (!$g) return response()->json(['status' => 'error','message' => 'Group not found'], 404);

        $token = Str::random(48);
        $inv = Invitation::create([
            'group_id' => $g->id,
            'email' => null,
            'token' => $token,
            'invited_by' => Auth::check() ? Auth::id() : null,
        ]);

        $link = url('/expense-management/invite/accept/'.$token);
        return response()->json(['status' => 'success', 'invitation' => [
            'id' => $inv->id,
            'email' => null,
            'link' => $link,
        ]]);
    }

    // Leave a group: remove current user identifiers from the group's members
    public function leave(Request $request, $group)
    {
        $g = ExpenseGroup::withTrashed()->find($group);
        if (!$g) return response()->json(['status' => 'error', 'message' => 'Group not found'], 404);

        $user = Auth::user();
        if (!$user) return response()->json(['status' => 'error', 'message' => 'Not authenticated'], 403);

        // Prevent the group owner from leaving — they should delete or transfer ownership instead
        if ($g->created_by && $g->created_by == $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Group owner cannot leave the group.'], 400);
        }

        $idents = array_filter([$user->name ?? null, $user->email ?? null]);
        if (empty($idents)) {
            return response()->json(['status' => 'error', 'message' => 'No identifiable membership to remove.'], 400);
        }

        $members = $g->members ?? [];
        $new = array_values(array_filter($members, function($m) use ($idents) {
            return !in_array($m, $idents, true);
        }));

        $g->members = $new;
        $g->save();

        return response()->json(['status' => 'success', 'redirect' => route('expense.index')]);
    }

    // Accept an invitation token. If the visitor is authenticated, add them to the group
    // and mark the invitation accepted. If not authenticated, show a small page instructing
    // them to login/register (the link will return them here).
    public function acceptInvite(Request $request, $token)
    {
        $inv = Invitation::where('token', $token)->first();
        if (!$inv) abort(404);

        // If invite was created for a specific email and already accepted, show already-accepted.
        if ($inv->email && $inv->accepted_at) {
            return view('expense.invite_accept', ['status' => 'already', 'invitation' => $inv]);
        }

        $group = ExpenseGroup::find($inv->group_id);
        if (!$group) abort(404);

        if (Auth::check()) {
            $user = Auth::user();
            // Add both name and email to members for reliable matching
            $members = $group->members ?? [];
            $nameId = $user->name ?: null;
            $emailId = $user->email ?: null;
            if ($nameId && !in_array($nameId, $members)) $members[] = $nameId;
            if ($emailId && !in_array($emailId, $members)) $members[] = $emailId;
            $group->members = $members;
            $group->save();
            $inv->accepted_at = now();
            $inv->save();

            return redirect()->route('expense.groups.show', ['group' => $group->id])->with('status', 'You joined the group.');
        }

        // Not authenticated: show page explaining next steps with links to login/register.
        return view('expense.invite_accept', ['status' => 'needs_auth', 'invitation' => $inv, 'group' => $group]);
    }

    // Show settle up / balances
    public function settle(Request $request, $group)
    {
        $g = ExpenseGroup::with(['expenses.shares'])->find($group);
        if (!$g) abort(404);

        $group = [
            'id' => $g->id,
            'name' => $g->name,
            'members' => $this->normalizeMembers($g->members ?? []),
            'expenses' => [],
        ];
        foreach ($g->expenses as $e) {
            $sarr = [];
            foreach ($e->shares as $s) $sarr[$s->member] = (float)$s->amount;
            $group['expenses'][] = [
                'id' => 'e'.$e->id,
                'title' => $e->note ?? 'Expense',
                'amount' => (float)$e->amount,
                'paid_by' => $e->payer_name ?? $e->payer_id,
                'category' => $e->category,
                'split_method' => $e->split_method,
                'shares' => $sarr,
                'created_at' => optional($e->spent_at)->toDateTimeString() ?? $e->created_at->toDateTimeString(),
            ];
        }
        return view('expense.settle', ['group' => $group]);
    }

    // Create a settlement snapshot that records current balances and marks them as settled
    public function doSettle(Request $request, $group)
    {
        $g = ExpenseGroup::with(['expenses.shares'])->find($group);
        if (!$g) return response()->json(['status' => 'error', 'message' => 'Group not found'], 404);

        $user = Auth::user();
        if (!$user) return response()->json(['status' => 'error', 'message' => 'Not authenticated'], 403);

        // build group expenses snapshot similar to show(), but only include
        // expenses that occurred after the most recent settlement (if any).
        $members = $this->normalizeMembers($g->members ?? []);
        $lastSettlement = Settlement::where('group_id', $g->id)->orderBy('created_at', 'desc')->first();

        $balances = array_fill_keys($members, 0.0);
        foreach ($g->expenses as $e) {
            // skip expenses at or before the last settlement timestamp
            if ($lastSettlement && $e->created_at <= $lastSettlement->created_at) continue;

            // accumulate shares
            foreach ($e->shares as $s) {
                $m = $s->member;
                $amt = (float)$s->amount;
                $mapped = $this->mapShareKey($m, $members);
                if (!isset($balances[$mapped])) $balances[$mapped] = 0.0;
                $balances[$mapped] -= $amt;
            }

            $payer = $this->mapShareKey($e->payer_name ?? $e->payer_id, $members);
            if (!isset($balances[$payer])) $balances[$payer] = 0.0;
            $balances[$payer] += (float)$e->amount;
        }

        // total settled amount is sum of positive balances
        $total = 0.0;
        $snapshot = [];
        foreach ($balances as $name => $b) {
            $snapshot[$name] = (float)$b;
            if ($b > 0) $total += (float)$b;
        }

        $sett = Settlement::create([
            'group_id' => $g->id,
            'created_by' => $user->id,
            'snapshot' => $snapshot,
            'total_amount' => $total,
        ]);

        return response()->json(['status' => 'success', 'redirect' => route('expense.groups.show', ['group' => $g->id])]);
    }

    // Delete a group (only owner can delete)
    public function destroy(Request $request, $group)
    {
        $g = ExpenseGroup::with(['expenses.shares'])->find($group);
        if (!$g) {
            if ($request->wantsJson()) return response()->json(['status' => 'error','message' => 'Group not found'], 404);
            abort(404);
        }

        $user = Auth::user();
        if (!$user) {
            if ($request->wantsJson()) return response()->json(['status' => 'error','message' => 'Not authenticated'], 403);
            abort(403);
        }

        if (!$g->created_by || $g->created_by != $user->id) {
            if ($request->wantsJson()) return response()->json(['status' => 'error','message' => 'Only the group owner can delete this group.'], 403);
            abort(403, 'Only the group owner can delete this group.');
        }

        // Soft-delete the group so members see it as "no longer existing" but data is preserved.
        $g->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'success', 'redirect' => route('expense.index')]);
        }

        return redirect()->route('expense.index')->with('success', 'Group deleted successfully');
    }

    // Download a simple CSV report for the group
    public function report(Request $request, $group)
    {
        $g = ExpenseGroup::with(['expenses.shares'])->find($group);
        if (!$g) abort(404);

        $filename = preg_replace('/[^a-z0-9]+/i', '-', strtolower($g->name))."-report-".date('Y-m-d').".csv";
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"$filename\""];

        $callback = function() use ($g) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Expense ID','Title','Amount','Paid By','Category','Date','Shares']);
            foreach ($g->expenses as $e) {
                $shares = [];
                foreach ($e->shares as $s) $shares[$s->member] = (float)$s->amount;
                fputcsv($out, ['e'.$e->id,$e->note ?? '',(float)$e->amount,$e->payer_name,$e->category,optional($e->spent_at)->toDateTimeString() ?? $e->created_at->toDateTimeString(),json_encode($shares)]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Normalize members for display: remove duplicate email entries when the
     * corresponding registered user's name is present. Preserve order and uniqueness.
     */
    private function normalizeMembers($members)
    {
        $members = array_values(array_filter((array)$members, fn($m) => $m !== null && $m !== ''));
        $seen = [];
        $unique = [];
        foreach ($members as $m) {
            if (in_array($m, $seen, true)) continue;
            $seen[] = $m;
            $unique[] = $m;
        }

        // For each email in the list, if there's a registered user with that email
        // and that user's name exists in the list, prefer the name and remove the email.
        $final = $unique;
        foreach ($unique as $m) {
            if (is_string($m) && str_contains($m, '@')) {
                $user = User::where('email', $m)->first();
                if ($user && $user->name) {
                    // if name is present, remove the email entry
                    if (in_array($user->name, $final, true)) {
                        $final = array_values(array_filter($final, fn($x) => $x !== $m));
                    }
                }
            }
        }

        return $final;
    }

    private function mapShareKey($key, $members)
    {
        if (!is_string($key)) return $key;
        if (str_contains($key, '@')) {
            $user = User::where('email', $key)->first();
            if ($user && $user->name && in_array($user->name, $members, true)) {
                return $user->name;
            }
        }
        return $key;
    }

    private function parseKeyValueString($str, $members)
    {
        // Accept formats: JSON like {"Alice":20,"Bob":40} or comma 'Alice:20,Bob:40' or values only '20,40'
        $out = [];
        if (!$str) return $out;
        $trim = trim($str);
        if (strpos($trim, '{') === 0) {
            $decoded = json_decode($trim, true);
            if (is_array($decoded)) return $decoded;
        }
        // comma separated pairs
        $parts = array_map('trim', explode(',', $trim));
        foreach ($parts as $i => $p) {
            if ($p === '') continue;
            if (strpos($p, ':') !== false) {
                [$k,$v] = array_map('trim', explode(':', $p, 2));
                $out[$k] = (float)$v;
            } else {
                // value only: assign in order to members
                if (isset($members[$i])) $out[$members[$i]] = (float)$p;
            }
        }
        return $out;
    }
}
