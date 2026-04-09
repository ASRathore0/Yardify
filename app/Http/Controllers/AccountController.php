<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /** Show the profile/account edit page */
    public function show()
    {
        $user = Auth::user();
        return view('account', compact('user'));
    }

    /** Handle profile updates and avatar upload */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:6',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if stored locally
            if (!empty($user->avatar_path) && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar_path'] = $path;
        }

        // If password provided, hash it and set; otherwise remove from validated
        if (!empty($validated['password'] ?? null)) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $oldName = $user->name;
        $newName = $validated['name'] ?? $oldName;

        $user->fill($validated);
        $user->save();

        // Update all associated expense records if name has changed
        if ($oldName !== $newName) {
            // 1. Update expense_groups members
            $groups = \App\Models\ExpenseGroup::whereJsonContains('members', $oldName)->get();
            foreach ($groups as $g) {
                $members = $g->members ?? [];
                foreach ($members as &$m) {
                    if ($m === $oldName) {
                        $m = $newName;
                    }
                }
                $g->members = $members;
                $g->save();
            }

            // 2. Update expenses payer_name
            \Illuminate\Support\Facades\DB::table('expenses')
                ->where('payer_name', $oldName)
                ->update(['payer_name' => $newName]);

            // 3. Update expense_shares member
            \Illuminate\Support\Facades\DB::table('expense_shares')
                ->where('member', $oldName)
                ->update(['member' => $newName]);
        }

        return redirect()->route('account.show')->with('status', 'Profile updated successfully.');
    }
}
