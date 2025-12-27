@extends('layouts.expense')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <a href="{{ route('expense.index') }}" class="text-xs font-bold text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition">
                    ← Back to Dashboard
                </a>
            </nav>
            <h1 class="text-3xl font-black text-slate-900">{{ $group['name'] }}</h1>
            <p class="text-slate-500 text-sm mt-1">
                Roommates: <span class="font-medium text-slate-700">{{ implode(', ', $group['members']) }}</span>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button id="openExpenseModalTop" type="button" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white rounded-xl font-bold shadow-sm hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="ml-2">Add Transaction</span>
            </button>
            <button id="markSettled" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 text-white rounded-xl font-bold shadow-sm hover:bg-emerald-700 transition">
                Mark Settled
            </button>
            <a href="{{ url('/expense-management/groups/'.$group['id'].'/report') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-white border border-slate-200 rounded-xl font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Download PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-4 space-y-6">

             <div class="bg-indigo-600 p-6 rounded-3xl text-white shadow-lg shadow-indigo-100">
                <h4 class="font-bold mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Settlement Tip
                </h4>
                <p class="text-indigo-100 text-xs leading-relaxed">
                    Always record payments immediately to keep balances accurate for everyone.
                </p>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">Current Balances</h3>
                <div class="space-y-3">
                    @foreach($group['balances'] as $name => $bal)
                        <div class="flex items-center justify-between p-4 rounded-2xl border {{ $bal >= 0 ? 'bg-green-50 border-green-100' : 'bg-red-50 border-red-100' }}">
                            <div>
                                <span class="font-bold text-slate-700">{{ $name }}</span>
                                <div class="text-[12px] text-slate-500 mt-1">Spent: <span class="font-semibold text-slate-700">₹{{ number_format($group['totals_paid'][$name] ?? 0, 2) }}</span></div>
                            </div>
                            <div class="text-right">
                                <span class="block text-[10px] uppercase font-bold opacity-60">
                                    {{ $bal >= 0 ? 'Gets back' : 'Owes' }}
                                </span>
                                <span class="font-black {{ $bal >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                    ₹{{ number_format(abs($bal), 2) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Invite Or Leave</h3>
                <div class="flex gap-3">
                    @csrf
                    <button id="createInviteLink" class="px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold">Invite</button>
                    <button id="leaveGroup" class="px-4 py-3 bg-red-500 text-white rounded-xl font-bold">Leave</button>
                </div>
                <p id="inviteMsg" class="text-sm text-slate-500 mt-3"></p>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            
             

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Expense History</h3>
                    <span class="text-xs text-slate-400">{{ count($group['expenses']) }} Total Items</span>
                </div>
                
                <div class="divide-y divide-slate-50">
                    @forelse($group['expenses'] as $e)
                        <div class="px-8 py-5 flex items-center justify-between hover:bg-slate-50 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 leading-tight">{{ $e['title'] }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        {{ $e['paid_by'] }} paid • {{ \Carbon\Carbon::parse($e['created_at'])->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-slate-900">₹{{ number_format($e['amount'], 2) }}</p>
                                <span class="text-[10px] px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded-full font-bold uppercase tracking-tighter">
                                    {{ $e['category'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <p class="text-slate-300 italic">No transactions recorded in this group yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Expense Modal -->
        <div id="expenseModal" class="fixed inset-0 z-50 hidden">
            <div id="expenseModalOverlay" class="absolute inset-0 bg-black/50"></div>
            <div class="relative flex items-center justify-center min-h-full p-4 sm:p-6">
                <div class="bg-white w-full max-w-xl rounded-3xl shadow-lg overflow-auto max-h-[95vh]">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-bold">Add New Transaction</h3>
                            <button id="closeExpenseModal" class="text-slate-400 hover:text-slate-600">✕</button>
                        </div>

                        <form id="expenseForm" class="space-y-4" method="POST" action="{{ url('/expense-management/groups/'.$group['id'].'/expenses') }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">What was it for?</label>
                                    <input name="title" placeholder="e.g. Monthly Rent or Groceries" required 
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Amount (₹)</label>
                                    <input name="amount" type="number" step="0.01" placeholder="0.00" required 
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition font-bold text-indigo-600">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Who Paid?</label>
                                    <select name="paid_by" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white outline-none">
                                        @foreach($group['members'] as $m)
                                            <option value="{{ $m }}">{{ $m }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 py-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Category</label>
                                    <select name="category" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-100 bg-slate-50">
                                        <option>Rent</option><option>Groceries</option><option>Utilities</option><option>Food</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Split Method</label>
                                    <select name="split_method" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-100 bg-slate-50">
                                        <option value="equal">Equally</option>
                                        <option value="exact">Exact Amount</option>
                                        <option value="percent">Percentage</option>
                                    </select>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="w-full py-3 bg-slate-900 text-white rounded-2xl font-black tracking-wide hover:bg-black transition-all">Save Transaction</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Confirmation Modal -->
        <div id="leaveModal" class="fixed inset-0 z-50 hidden">
            <div id="leaveModalOverlay" class="absolute inset-0 bg-black/50"></div>
            <div class="relative flex items-center justify-center min-h-full p-4 sm:p-6">
                <div class="bg-white w-full max-w-md rounded-3xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-bold">Leave Group</h3>
                            <button id="closeLeaveModal" class="text-slate-400 hover:text-slate-600">✕</button>
                        </div>
                        <p class="text-sm text-slate-600 mb-4">Are you sure you want to leave the group <span class="font-semibold">{{ $group['name'] }}</span>? This will remove you from the group's member list and cannot be undone.</p>
                        <div class="flex justify-end gap-3">
                            <button id="cancelLeave" class="px-4 py-2 bg-white border border-slate-200 rounded-xl font-bold text-slate-700 hover:bg-slate-50">Cancel</button>
                            <button id="confirmLeave" class="px-4 py-2 bg-red-600 text-white rounded-xl font-bold">Leave Group</button>
                        </div>
                        <p id="leaveMsg" class="text-sm text-slate-500 mt-3"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settle Confirmation Modal -->
        <div id="settleModal" class="fixed inset-0 z-50 hidden">
            <div id="settleModalOverlay" class="absolute inset-0 bg-black/50"></div>
            <div class="relative flex items-center justify-center min-h-full p-4 sm:p-6">
                <div class="bg-white w-full max-w-md rounded-3xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-bold">Settle Group Balances</h3>
                            <button id="closeSettleModal" class="text-slate-400 hover:text-slate-600">✕</button>
                        </div>
                        <p class="text-sm text-slate-600 mb-4">This will record a settlement for the group's current balances and mark them as settled in the history. Balances will be cleared visually after settlement.</p>
                        <div class="flex justify-end gap-3">
                            <button id="cancelSettle" class="px-4 py-2 bg-white border border-slate-200 rounded-xl font-bold text-slate-700 hover:bg-slate-50">Cancel</button>
                            <button id="confirmSettle" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold">Settle Now</button>
                        </div>
                        <p id="settleMsg" class="text-sm text-slate-500 mt-3"></p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            (function(){
                const modal = document.getElementById('expenseModal');
                const overlay = document.getElementById('expenseModalOverlay');
                const openTop = document.getElementById('openExpenseModalTop');
                const openMain = document.getElementById('openExpenseModal');
                const close = document.getElementById('closeExpenseModal');

                function openModal(){
                    if(!modal) return;
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
                function closeModal(){
                    if(!modal) return;
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                if(openTop) openTop.addEventListener('click', openModal);
                if(openMain) openMain.addEventListener('click', openModal);
                if(close) close.addEventListener('click', closeModal);
                if(overlay) overlay.addEventListener('click', closeModal);
                document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeModal(); });
            })();
        </script>

        <script>
            // Create reusable invite link (no email required) and open system share when available
            (function(){
                const btn = document.getElementById('createInviteLink');
                const leaveBtn = document.getElementById('leaveGroup');
                const inviteMsg = document.getElementById('inviteMsg');
                if(!btn && !leaveBtn) return;
                function getCsrf(){
                    const meta = document.querySelector('meta[name="csrf-token"]');
                    if(meta) return meta.getAttribute('content');
                    const input = document.querySelector('input[name="_token"]');
                    return input ? input.value : '';
                }

                btn.addEventListener('click', async function(e){
                    e.preventDefault();
                    inviteMsg.textContent = '';
                    btn.disabled = true;
                    try{
                        const res = await fetch("/expense-management/groups/{{ $group['id'] }}/invite", {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: { 'X-CSRF-TOKEN': getCsrf(), 'Accept': 'application/json' },
                        });
                        const js = await res.json();
                        if(js.status === 'success'){
                            const link = js.invitation.link;
                            // Try Web Share API
                            if (navigator.share) {
                                try {
                                    await navigator.share({
                                        title: 'Join my group on BookingYard',
                                        text: 'Join the expense group "{{ addslashes($group['name']) }}"',
                                        url: link
                                    });
                                    inviteMsg.textContent = 'Share dialog opened';
                                } catch (shareErr) {
                                    // share canceled or failed, fall back to showing link
                                    inviteMsg.innerHTML = renderLinkFallback(link);
                                }
                            } else {
                                inviteMsg.innerHTML = renderLinkFallback(link);
                            }
                        } else {
                            inviteMsg.textContent = js.message || 'Failed to create invite';
                        }
                    } catch(err){
                        inviteMsg.textContent = 'Error creating invite';
                        console.error(err);
                    } finally { btn.disabled = false; }
                });

                // Leave group handler: open modal and perform POST when confirmed
                const leaveModal = document.getElementById('leaveModal');
                const leaveOverlay = document.getElementById('leaveModalOverlay');
                const closeLeave = document.getElementById('closeLeaveModal');
                const cancelLeave = document.getElementById('cancelLeave');
                const confirmLeave = document.getElementById('confirmLeave');
                const leaveMsg = document.getElementById('leaveMsg');

                function openLeaveModal(){ if(!leaveModal) return; leaveModal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
                function closeLeaveModal(){ if(!leaveModal) return; leaveModal.classList.add('hidden'); document.body.style.overflow = 'auto'; leaveMsg.textContent = ''; }

                if(leaveBtn){
                    leaveBtn.addEventListener('click', function(e){ e.preventDefault(); openLeaveModal(); });
                }
                if(closeLeave) closeLeave.addEventListener('click', closeLeaveModal);
                if(cancelLeave) cancelLeave.addEventListener('click', closeLeaveModal);
                if(leaveOverlay) leaveOverlay.addEventListener('click', closeLeaveModal);

                if(confirmLeave){
                    confirmLeave.addEventListener('click', async function(e){
                        e.preventDefault();
                        leaveMsg.textContent = '';
                        confirmLeave.disabled = true;
                        if(leaveBtn) leaveBtn.disabled = true;
                        if(btn) btn.disabled = true;
                        try{
                            const res = await fetch("/expense-management/groups/{{ $group['id'] }}/leave", {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: { 'X-CSRF-TOKEN': getCsrf(), 'Accept': 'application/json' },
                            });
                            const js = await res.json();
                            if(js.status === 'success'){
                                window.location = js.redirect || '{{ route('expense.index') }}';
                            } else {
                                leaveMsg.textContent = js.message || 'Failed to leave group';
                            }
                        } catch(err){
                            leaveMsg.textContent = 'Error leaving group';
                            console.error(err);
                        } finally { confirmLeave.disabled = false; if(leaveBtn) leaveBtn.disabled = false; if(btn) btn.disabled = false; }
                    });
                }

                // Settle handlers
                const settleBtn = document.getElementById('markSettled');
                const settleModal = document.getElementById('settleModal');
                const settleOverlay = document.getElementById('settleModalOverlay');
                const closeSettle = document.getElementById('closeSettleModal');
                const cancelSettle = document.getElementById('cancelSettle');
                const confirmSettle = document.getElementById('confirmSettle');
                const settleMsg = document.getElementById('settleMsg');

                function openSettleModal(){ if(!settleModal) return; settleModal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
                function closeSettleModal(){ if(!settleModal) return; settleModal.classList.add('hidden'); document.body.style.overflow = 'auto'; settleMsg.textContent = ''; }
                if(settleBtn) settleBtn.addEventListener('click', function(e){ e.preventDefault(); openSettleModal(); });
                if(closeSettle) closeSettle.addEventListener('click', closeSettleModal);
                if(cancelSettle) cancelSettle.addEventListener('click', closeSettleModal);
                if(settleOverlay) settleOverlay.addEventListener('click', closeSettleModal);

                if(confirmSettle){
                    confirmSettle.addEventListener('click', async function(e){
                        e.preventDefault();
                        settleMsg.textContent = '';
                        confirmSettle.disabled = true;
                        try{
                            const res = await fetch("/expense-management/groups/{{ $group['id'] }}/settle", {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: { 'X-CSRF-TOKEN': getCsrf(), 'Accept': 'application/json' },
                            });
                            const js = await res.json();
                            if(js.status === 'success'){
                                window.location = js.redirect || '{{ route('expense.groups.show', ['group' => $group['id']]) }}';
                            } else {
                                settleMsg.textContent = js.message || 'Failed to settle group';
                            }
                        } catch(err){
                            settleMsg.textContent = 'Error settling group';
                            console.error(err);
                        } finally { confirmSettle.disabled = false; }
                    });
                }

                function renderLinkFallback(link){
                    const escaped = link.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    return 'Invite link created — <a target="_blank" href="'+escaped+'">Open link</a> <button id="copyInviteBtn" class="ml-3 px-3 py-1 bg-slate-100 rounded">Copy</button> <div id="copyMsg" class="text-sm text-slate-500 mt-2">'+escaped+'</div>';
                }

                document.addEventListener('click', function(e){
                    if(e.target && e.target.id === 'copyInviteBtn'){
                        const txt = document.getElementById('copyMsg');
                        if(!txt) return;
                        const toCopy = txt.textContent || txt.innerText || '';
                        if(navigator.clipboard && navigator.clipboard.writeText){
                            navigator.clipboard.writeText(toCopy).then(()=>{ txt.textContent = 'Copied to clipboard'; setTimeout(()=>{ txt.textContent = toCopy; },2000); }).catch(()=>{ txt.textContent = 'Copy failed'; });
                        } else {
                            // fallback
                            const range = document.createRange(); const sel = window.getSelection(); range.selectNodeContents(txt); sel.removeAllRanges(); sel.addRange(range);
                            try { document.execCommand('copy'); txt.textContent = 'Copied to clipboard'; setTimeout(()=>{ txt.textContent = toCopy; },2000); } catch(e){ txt.textContent = 'Copy failed'; }
                        }
                    }
                });
            })();
        </script>