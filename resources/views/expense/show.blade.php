@extends('layouts.expense')

@section('content')

@include('partials.header')
@include('partials.sidebar')

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<div class="max-w-6xl mx-auto px-4 mt-5 md:mt-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 md:mb-8 mt-24">
        <div>
            <h1 class="text-3xl font-black text-slate-900">{{ $group['name'] }}</h1>
            <div class="flex items-center gap-2 mt-2">
                <div class="flex -space-x-2">
                    @foreach($group['members'] as $m)
                        @if(!empty($m['avatar']))
                             <img src="{{ $m['avatar'] }}" alt="{{ $m['name'] }}" class="w-8 h-8 rounded-full border-2 border-white object-cover" title="{{ $m['name'] }}">
                        @else
                             <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600" title="{{ $m['name'] }}">
                                {{ $m['initial'] }}
                             </div>
                        @endif
                    @endforeach
                </div>
                <span class="text-slate-500 text-sm font-medium ml-2">{{ count($group['members']) }} members</span>
            </div>
        </div>
        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 md:gap-3 w-full md:w-auto">
            <button id="openExpenseModalTop" type="button" class="flex-1 sm:flex-none inline-flex justify-center items-center px-4 py-2 bg-[#046c9f] text-white rounded-xl font-bold text-sm md:text-base shadow-sm hover:bg-[#035680] transition whitespace-nowrap">
                <svg width="16" height="16" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="ml-1 md:ml-2 block sm:hidden">Add</span>
                <span class="ml-1 md:ml-2 hidden sm:block">Add Transaction</span>
            </button>
            <a href="{{ route('expense.index') }}" 
               class="flex-1 sm:flex-none inline-flex justify-center items-center px-4 py-2 bg-white border border-slate-200 rounded-xl font-bold text-sm md:text-base text-slate-700 shadow-sm hover:bg-slate-50 transition whitespace-nowrap">
                <svg width="16" height="16" class="w-4 h-4 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="block sm:hidden">Back</span>
                <span class="hidden sm:block">Back To Dashboard</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-4 space-y-6">

             <div class="bg-[#046c9f] p-6 rounded-3xl text-white shadow-lg shadow-indigo-100">
                <h4 class="font-bold mb-2 flex items-center">
                    <svg width="20" height="20" class="w-5 h-5 mr-2" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Settlement Tip
                </h4>
                <p class="text-indigo-100 text-xs leading-relaxed">
                    Always record payments immediately to keep balances accurate for everyone.
                </p>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-start justify-between mb-6">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Current Balances</h3>
                    <button id="markSettled" class="px-3 py-2 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700">Mark Settled</button>
                </div>
                <div class="space-y-3">
                    @foreach($group['balances'] as $name => $bal)
                        @php
                            $m = collect($group['members'])->firstWhere('name', $name) ?? ['name' => $name, 'initial' => substr($name, 0, 1), 'avatar' => null];
                        @endphp
                        <div class="flex items-center justify-between p-4 rounded-2xl border {{ $bal >= 0 ? 'bg-green-50 border-green-100' : 'bg-red-50 border-red-100' }}">
                            <div class="flex items-center gap-3">
                                @if(!empty($m['avatar']))
                                     <img src="{{ $m['avatar'] }}" alt="{{ $m['name'] }}" class="w-10 h-10 rounded-full bg-white border border-slate-100 object-cover shadow-sm">
                                @else
                                     <div class="w-10 h-10 rounded-full bg-white border border-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm shadow-sm">
                                        {{ $m['initial'] }}
                                     </div>
                                @endif
                                <div>
                                    <span class="font-bold text-slate-800 block leading-tight">{{ $name }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium">Spent: ₹{{ number_format($group['totals_paid'][$name] ?? 0, 0) }}</span>
                                </div>
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
                    <button id="createInviteLink" class="px-4 py-3 bg-[#046c9f] text-white rounded-xl font-bold">Invite</button>
                    <button id="leaveGroup" class="px-4 py-3 bg-red-500 text-white rounded-xl font-bold">Leave</button>
                </div>
                <p id="inviteMsg" class="text-sm text-slate-500 mt-3"></p>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            
             

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 text-lg">History</h3>
                    <div class="flex items-center gap-3">
                        <form method="GET" id="perPageForm" action="{{ url()->current() }}" class="flex items-center m-0">
                            <div class="relative">
                                <select name="per_page" class="appearance-none text-xs bg-slate-50 hover:bg-slate-100 rounded-lg pl-3 pr-7 py-2 font-bold text-slate-600 focus:outline-none transition-colors cursor-pointer border-0" onchange="document.getElementById('perPageForm').submit()">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>Show 10</option>
                                    <option value="20" {{ request('per_page',) == 20 ? 'selected' : '' }}>Show 20</option>
                                    <option value="40" {{ request('per_page') == 40 ? 'selected' : '' }}>Show 40</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>Show 50</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <svg width="12" height="12" class="w-3 h-3 fill-current" style="width: 0.75rem; height: 0.75rem;" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                </div>
                            </div>
                        </form>
                        <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>
                        <span class="text-xs text-slate-400 font-medium whitespace-nowrap">{{ $group['expenses']->total() }} items</span>
                    </div>
                </div>
                
                <div class="divide-y divide-slate-50">
                    @forelse($group['expenses'] as $e)
                        <div class="px-6 py-5 flex items-center justify-between hover:bg-slate-50 transition cursor-pointer {{ $e['category'] === 'Settled' ? 'settlement-item' : 'expense-item' }}"
                             data-shares="{{ json_encode($e['shares']) }}"
                             data-date="{{ \Carbon\Carbon::parse($e['created_at'])->format('M d, Y, h:i A') }}"
                             @if($e['category'] !== 'Settled')
                                 data-id="{{ $e['raw_id'] }}"
                                 data-created-by="{{ $e['created_by'] }}"
                                 data-title="{{ $e['title'] }}"
                                 data-amount="{{ $e['amount'] }}"
                                 data-paid-by="{{ $e['paid_by'] }}"
                                 data-category="{{ $e['category'] }}"
                                 data-is-edited="{{ $e['is_edited'] }}"
                             @endif
                        >
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full {{ $e['category'] === 'Settled' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center">
                                    @if($e['category'] === 'Settled')
                                        <svg width="20" height="20" class="w-5 h-5" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @else
                                        <svg width="20" height="20" class="w-5 h-5" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 leading-tight">
                                        {{ $e['title'] }}
                                        @if($e['is_edited'])
                                            <span class="text-[10px] text-slate-400 font-normal italic ml-1">(edited)</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        {{ $e['paid_by'] }} paid • {{ \Carbon\Carbon::parse($e['created_at'])->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-slate-900">₹{{ number_format($e['amount'], 2) }}</p>
                                <span class="text-[10px] px-2 py-0.5 {{ $e['category'] === 'Settled' ? 'bg-emerald-50 text-emerald-600' : 'bg-[#e0f2fe] text-[#046c9f]' }} rounded-full font-bold uppercase tracking-tighter">
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
                @if($group['expenses']->hasPages())
                    <div class="px-8 py-5 border-t border-slate-50">
                        {{ $group['expenses']->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

        <!-- Expense Modal -->
         <div id="expenseModal" class="fixed inset-0 z-40 hidden">
            <div id="expenseModalOverlay" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('closeExpenseModal').click()"></div>
            <div id="expenseModalWrapper" class="relative flex items-end sm:items-center justify-center min-h-full p-0 sm:p-6 z-10" onclick="if(event.target === this) document.getElementById('closeExpenseModal').click()">
                <div class="bg-white pointer-events-auto w-full sm:max-w-[420px] rounded-t-[2rem] sm:rounded-[1.5rem] shadow-2xl h-[85vh] sm:h-auto max-h-[vh] sm:max-h-[vh] flex flex-col overflow-hidden transform transition-transform translate-y-0">
                    
                    <!-- Drag Handle (Mobile only) -->
                    <div class="w-full flex justify-center py-3 sm:hidden absolute top-0 left-0 right-0 z-20 pointer-events-none">
                        <div class="w-12 h-1.5 bg-slate-200 rounded-full"></div>
                    </div>

                    <!-- Header -->
                    <div class="px-5 pt-8 sm:pt-5 pb-4 border-b border-slate-100 flex items-center justify-between shrink-0 bg-white relative z-10">
                        <h3 id="expenseModalTitle" class="text-lg sm:text-[19px] font-black text-slate-800 tracking-tight">Add Transaction</h3>
                        <button id="closeExpenseModal" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors focus:outline-none">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <!-- Scrollable Body -->
                    <div class="p-5 sm:p-6 overflow-y-auto custom-scrollbar flex-1 relative bg-white">
                        <form id="expenseForm" class="space-y-6" method="POST" action="{{ url('/expense-management/groups/'.$group['id'].'/expenses') }}">
                            @csrf
                            <div id="method-spoof"></div>
                            
                            <!-- Amount Section -->
                            <div class="flex flex-col pb-2">
                                <label for="amountInput" class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Amount</label>
                                <div class="relative flex items-center w-full bg-white border border-slate-200 focus-within:border-[#046c9f] focus-within:ring-2 focus-within:ring-[#046c9f]/20 rounded-[1.25rem] shadow-sm transition-all p-2">
                                    <div class="flex items-center justify-center bg-[#f0f9ff] text-[#046c9f] border border-[#bae6fd] w-14 h-14 rounded-xl shrink-0">
                                        <span class="text-2xl font-bold">₹</span>
                                    </div>
                                    <div class="flex-1 pl-4 pr-2">
                                        <input id="amountInput" name="amount" type="number" step="0.01" placeholder="0.00" required 
                                            class="w-full bg-transparent border-none text-3xl font-black text-slate-800 focus:ring-0 placeholder-slate-200 p-0 m-0">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Details Card -->
                            <div class="bg-slate-50 p-4 rounded-[1.25rem] border border-slate-100 space-y-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">Title</label>
                                    <input name="title" placeholder="e.g. Dinner, Groceries" required 
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-[#046c9f] focus:ring-2 focus:ring-[#046c9f]/20 outline-none transition text-[15px] font-semibold text-slate-800 placeholder-slate-400 bg-white shadow-sm">
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">Who Paid?</label>
                                        @php $me = auth()->user() ? (auth()->user()->name ?: auth()->user()->email) : null; @endphp
                                        <div class="relative">
                                            <select name="paid_by" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white shadow-sm focus:border-[#046c9f] focus:ring-2 focus:ring-[#046c9f]/20 outline-none transition appearance-none text-[14px] font-semibold text-slate-800 cursor-pointer pr-10">
                                                @foreach($group['members'] as $m)
                                                    <option value="{{ $m['name'] }}" @if($me && $me == $m['name']) selected @endif>{{ $m['name'] }}</option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400">
                                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 sm:gap-3">
                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 ml-1 flex items-center gap-1 group relative cursor-help">
                                                Category
                                            </label>
                                            <div class="relative">
                                                <select name="category" class="w-full pl-3 pr-6 py-3 rounded-xl border border-slate-200 bg-white shadow-sm focus:border-[#046c9f] focus:ring-2 focus:ring-[#046c9f]/20 outline-none transition appearance-none text-[13px] font-semibold text-slate-700 cursor-pointer">
                                                    <option>General</option><option>Rent</option><option>Groceries</option><option>Food</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none text-slate-400">
                                                    <i class="fa-solid fa-chevron-down text-[9px]"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">Split</label>
                                            <div class="relative">
                                                <select name="split_method" class="w-full pl-3 pr-6 py-3 rounded-xl border border-slate-200 bg-white shadow-sm focus:border-[#046c9f] focus:ring-2 focus:ring-[#046c9f]/20 outline-none transition appearance-none text-[13px] font-semibold text-slate-700 cursor-pointer">
                                                    <option value="equal">Equally</option>
                                                    <option value="exact">Exact</option>
                                                    <option value="percent">Percent</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none text-slate-400">
                                                    <i class="fa-solid fa-chevron-down text-[9px]"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Split Members -->
                            <div class="pt-1">
                                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-users text-slate-400 text-xs"></i> Split Between
                                </label>
                                <input type="hidden" name="is_custom_split" value="1">
                                <div class="flex flex-wrap gap-2" id="member-chips">
                                    @foreach($group['members'] as $index => $m)
                                        <button type="button"
                                            onclick="toggleExpenseMember(this, '{{ $index }}')"
                                            class="px-3 py-1.5 rounded-xl text-[13px] font-bold border transition-all select-none bg-[#e0f2fe] text-[#046c9f] border-[#046c9f] shadow-sm flex items-center gap-2 hover:brightness-95 active:scale-95">
                                            @if(!empty($m['avatar']))
                                                <img src="{{ $m['avatar'] }}" class="w-5 h-5 rounded-full object-cover">
                                            @endif
                                            <span>{{ $m['name'] }}</span>
                                            <span class="text-[10px] opacity-60">✕</span>
                                        </button>
                                        <input type="hidden" name="involved_members[]" value="{{ $m['name'] }}" id="hidden-input-{{ $index }}">
                                    @endforeach
                                </div>
                                <p class="text-[11px] text-slate-400 mt-3 ml-1 leading-snug font-medium">Deselected members won't be charged for this transaction.</p>
                            </div>
                        </form>
                    </div>

                    <!-- Footer Sticky Action Area -->
                    <div class="p-4 sm:p-5 border-t border-slate-100 bg-white shrink-0 z-10 w-full flex justify-end shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.02)]">
                        <button type="button" onclick="document.getElementById('closeExpenseModal').click()" class="px-5 py-3 text-slate-500 font-bold text-sm hover:bg-slate-50 hover:text-slate-800 rounded-xl transition mr-2 hidden sm:block">Cancel</button>
                        <button type="submit" form="expenseForm" class="w-full sm:w-auto px-6 py-3.5 bg-[#046c9f] hover:bg-[#035b88] text-white rounded-xl font-bold text-[15px] shadow-lg shadow-blue-900/20 transition-all focus:ring-4 focus:ring-[#046c9f]/30 active:scale-[0.98] flex items-center justify-center gap-2">
                            Save Transaction
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Leave Confirmation Modal -->
        <div id="leaveModal" class="fixed inset-0 z-40 hidden">
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
        <div id="settleModal" class="fixed inset-0 z-40 hidden">
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

        <!-- Settlement Details Modal -->
        <div id="settlementDetailsModal" class="fixed inset-0 z-40 hidden">
            <div id="sdOverlay" class="absolute inset-0 bg-black/50"></div>
            <div class="relative flex items-center justify-center min-h-full p-4 sm:p-6">
                <div class="bg-white w-full max-w-sm rounded-3xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold">Settlement Details</h3>
                                <p id="sdDate" class="text-xs text-slate-400 mt-1"></p>
                            </div>
                            <button id="closeSD" class="text-slate-400 hover:text-slate-600">✕</button>
                        </div>
                        
                        <div class="space-y-3" id="sdList">
                            <!-- Populated via JS -->
                        </div>

                        <div class="mt-6 text-center">
                            <button id="closeSDBtn" class="px-6 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expense Details Modal -->
        <div id="expenseDetailsModal" class="fixed inset-0 z-40 hidden">
            <div id="edOverlay" class="absolute inset-0 bg-black/50"></div>
            <div class="relative flex items-center justify-center min-h-full p-4 sm:p-6">
                <div class="bg-white w-full max-w-sm rounded-3xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold truncate max-w-[200px]" id="edTitle">Expense Details</h3>
                                <p id="edDate" class="text-xs text-slate-400 mt-1"></p>
                            </div>
                            <button id="closeED" class="text-slate-400 hover:text-slate-600">✕</button>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl mb-4">
                             <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-slate-500">Paid By</span>
                                <span class="text-sm font-bold text-slate-800" id="edPaidBy"></span>
                             </div>
                             <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold text-slate-500">Total Amount</span>
                                <span class="text-xl font-black text-slate-900" id="edAmount"></span>
                             </div>
                        </div>
                        
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Split Details</h4>
                        <div class="space-y-2 max-h-[300px] overflow-y-auto" id="edList">
                            <!-- Populated via JS -->
                        </div>

                        <div class="mt-6 text-center flex flex-col gap-3">
                             <div id="expenseActions" class="hidden grid grid-cols-2 gap-3 mb-2">
                                <button id="editExpenseBtn" class="px-4 py-2 bg-[#046c9f] text-white rounded-xl font-bold text-sm hover:bg-[#035680]">Edit</button>
                                <button id="deleteExpenseBtn" class="px-4 py-2 bg-red-100 text-red-600 border border-red-200 rounded-xl font-bold text-sm hover:bg-red-50">Delete</button>
                             </div>
                            <button id="closeEDBtn" class="px-6 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <form id="deleteExpenseForm" method="POST" class="hidden">@csrf @method('DELETE')</form>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteConfirmModal" class="fixed inset-0 z-40 hidden">
            <div id="deleteConfirmOverlay" class="absolute inset-0 bg-black/50"></div>
            <div class="relative flex items-center justify-center min-h-full p-4 sm:p-6">
                <div class="bg-white w-full max-w-md rounded-3xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-bold text-red-600">Delete Transaction</h3>
                            <button id="closeDeleteConfirm" class="text-slate-400 hover:text-slate-600">✕</button>
                        </div>
                        <p class="text-sm text-slate-600 mb-6">Are you sure you want to delete this transaction? This cannot be undone.</p>
                        <div class="flex justify-end gap-3">
                            <button id="cancelDelete" class="px-4 py-2 bg-white border border-slate-200 rounded-xl font-bold text-slate-700 hover:bg-slate-50">Cancel</button>
                            <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700">Delete It</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
        <script>
            function toggleExpenseMember(btn, index) {
                const input = document.getElementById('hidden-input-' + index);
                const isSelected = btn.classList.contains('bg-[#e0f2fe]');
                
                if (isSelected) {
                    deselectMember(btn, input);
                } else {
                    selectMember(btn, input);
                }
            }

            function deselectMember(btn, input) {
                btn.classList.remove('bg-[#e0f2fe]', 'text-[#046c9f]', 'border-[#046c9f]');
                btn.classList.add('bg-slate-50', 'text-slate-400', 'border-slate-200', 'line-through', 'opacity-70');
                input.disabled = true; 
                btn.querySelector('span:last-child').textContent = '+'; 
            }

            function selectMember(btn, input) {
                btn.classList.add('bg-[#e0f2fe]', 'text-[#046c9f]', 'border-[#046c9f]');
                btn.classList.remove('bg-slate-50', 'text-slate-400', 'border-slate-200', 'line-through', 'opacity-70');
                input.disabled = false;
                btn.querySelector('span:last-child').textContent = '✕';
            }
        </script>

        <script>
            (function(){
                const modal = document.getElementById('expenseModal');
                const overlay = document.getElementById('expenseModalOverlay');
                const openTop = document.getElementById('openExpenseModalTop');
                const openMain = document.getElementById('openExpenseModal');
                const close = document.getElementById('closeExpenseModal');
                const form = document.getElementById('expenseForm');
                const modalTitle = document.getElementById('expenseModalTitle');
                const methodSpoof = document.getElementById('method-spoof');
                const defaultAction = form ? form.action : '';
                
                // Expose openEditModal globally (dirty but works)
                window.openEditModal = function(item) {
                     if(!modal) return;
                     
                     // Set to Edit Mode
                     modalTitle.textContent = 'Edit Transaction';
                     form.action = "{{ url('/expense-management/expenses') }}/" + item.dataset.id;
                     methodSpoof.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                     
                     // Populate fields
                     form.elements['title'].value = item.dataset.title || '';
                     form.elements['amount'].value = item.dataset.amount || '';
                     form.elements['paid_by'].value = item.dataset.paidBy || '';
                     form.elements['category'].value = item.dataset.category || 'Rent';
                     
                     // Reset members: first select all logic, then verify against shares
                     // BUT, shares includes ALL members with 0 amount usually? No, show logic iterates over non-zero.
                     // The backend stores ONLY members with amounts in DB? No, stores all shares usually 0 or not.
                     // The `data-shares` is JSON object {name: amount}.
                     // If amount > 0 => member is involved.
                     
                     const shares = JSON.parse(item.dataset.shares || '{}');
                     const involvedNames = Object.keys(shares).filter(k => Math.abs(parseFloat(shares[k])) > 0.001);
                     
                     // If split method is equal, we select strictly based on involved
                     // For exact/percent, current simple edit form doesn't support fine grained editing yet, falls back to "Equal among selected"
                     // User will overwrite split method to 'equal' effectively if they save.
                     // For now let's assume simple equal split editing.
                     
                     // Iterate all member toggles
                     const chips = document.getElementById('member-chips').children;
                     // Each child is button + hidden input. But loop structure is button, hidden, button, hidden...
                     // Wait, blade loop: button, input. So children[0] is button, children[1] is input...
                     // Actually easier to select by ID since we have indices.
                     // But we don't have indices easily in JS unless we iterate.
                     
                     // Let's iterate inputs starting with 'hidden-input-'
                     const inputs = document.querySelectorAll('input[id^="hidden-input-"]');
                     inputs.forEach(input => {
                         const name = input.value; // The name of member
                         const index = input.id.replace('hidden-input-', '');
                         const btn = input.previousElementSibling; 
                         
                         // Check if name is in involvedNames
                         if (involvedNames.includes(name)) {
                             selectMember(btn, input);
                         } else {
                             deselectMember(btn, input);
                         }
                     });
                     
                     modal.classList.remove('hidden');
                     document.body.style.overflow = 'hidden';
                     
                     // Close details modal if open
                     const detailsModal = document.getElementById('expenseDetailsModal');
                     if(detailsModal && !detailsModal.classList.contains('hidden')){
                         detailsModal.classList.add('hidden');
                         // Also hide actions div in details modal
                         const actions = document.getElementById('expenseActions');
                         if(actions) actions.classList.add('hidden');
                     }
                     const fnav = document.getElementById('footer');
                     if (fnav) fnav.style.display = 'none';
                };

                function openModal(){
                    if(!modal) return;
                    // Reset to Create Mode
                    modalTitle.textContent = 'Add Transaction';
                    if(form) {
                        form.action = defaultAction;
                        form.reset();
                    }
                    if(methodSpoof) methodSpoof.innerHTML = '';
                    
                    // Select all members by default
                    const inputs = document.querySelectorAll('input[id^="hidden-input-"]');
                    inputs.forEach(input => {
                         const btn = input.previousElementSibling;
                         selectMember(btn, input);
                    });
                    
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    const fnav = document.getElementById('footer');
                    if (fnav) fnav.style.display = 'none';
                }
                function closeModal(){
                    if(!modal) return;
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    const fnav = document.getElementById('footer');
                    if (fnav) fnav.style.display = '';
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
                            const shareData = {
                                title: 'Join BookingYard Group',
                                text: 'Join the expense group "{{ addslashes($group["name"]) }}" on BookingYard',
                                url: link
                            };

                            // Try Web Share API
                            if (navigator.share) {
                                try {
                                    await navigator.share(shareData);
                                    inviteMsg.textContent = ''; // Clear "Generating..." text on success
                                } catch (shareErr) {
                                    // If user cancelled (AbortError), do nothing. Otherwise show link.
                                    if (shareErr.name !== 'AbortError') {
                                        inviteMsg.innerHTML = renderLinkFallback(link);
                                    }
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

        <script>
            // Settlement Details Handler
            (function(){
                const modal = document.getElementById('settlementDetailsModal');
                const overlay = document.getElementById('sdOverlay');
                const closeIcon = document.getElementById('closeSD');
                const closeBtn = document.getElementById('closeSDBtn');
                const list = document.getElementById('sdList');
                const dateEl = document.getElementById('sdDate');

                function closeModal(){
                    if(modal) {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                }

                if(overlay) overlay.addEventListener('click', closeModal);
                if(closeIcon) closeIcon.addEventListener('click', closeModal);
                if(closeBtn) closeBtn.addEventListener('click', closeModal);
                // Close on escape
                document.addEventListener('keydown', function(e){ if(e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });

                document.addEventListener('click', function(e){
                    const item = e.target.closest('.settlement-item');
                    if(item){
                        const sharesRaw = item.dataset.shares;
                        const dateStr = item.dataset.date;
                        if(sharesRaw && modal){
                            try {
                                const shares = JSON.parse(sharesRaw);
                                list.innerHTML = '';
                                dateEl.textContent = dateStr || '';
                                
                                let hasItems = false;
                                for(let [name, bal] of Object.entries(shares)){
                                    if(Math.abs(bal) < 0.01) continue;
                                    hasItems = true;
                                    const isOwe = bal < 0;
                                    const amount = Math.abs(bal).toFixed(2);
                                    
                                    const row = document.createElement('div');
                                    row.className = 'flex items-center justify-between p-3 rounded-xl border ' + (isOwe ? 'bg-red-50 border-red-100' : 'bg-green-50 border-green-100');
                                    
                                    row.innerHTML = `
                                        <div>
                                            <span class="font-bold text-slate-700">${name}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="block text-[10px] uppercase font-bold opacity-60">${isOwe ? 'Owes' : 'Gets Back'}</span>
                                            <span class="font-black ${isOwe ? 'text-red-700' : 'text-green-700'}">₹${amount}</span>
                                        </div>
                                    `;
                                    list.appendChild(row);
                                }
                                if(!hasItems){
                                    list.innerHTML = '<p class="text-center text-slate-400 text-sm">Balanced Settlement (Zeros)</p>';
                                }

                                modal.classList.remove('hidden');
                                document.body.style.overflow = 'hidden';

                            } catch(err){ console.error('Error parsing settlement data', err); }
                        }
                    }
                });
            })();
        </script>

        <script>
            // Expense Details Handler
            (function(){
                const modal = document.getElementById('expenseDetailsModal');
                const overlay = document.getElementById('edOverlay');
                const closeIcon = document.getElementById('closeED');
                const closeBtn = document.getElementById('closeEDBtn');
                const list = document.getElementById('edList');
                const titleEl = document.getElementById('edTitle');
                const dateEl = document.getElementById('edDate');
                const paidByEl = document.getElementById('edPaidBy');
                const amountEl = document.getElementById('edAmount');
                const groupMembers = @json($group['members']);
                const currentUserId = {{ auth()->id() ?? 'null' }};

                const actionsDiv = document.getElementById('expenseActions');
                const deleteBtn = document.getElementById('deleteExpenseBtn');
                const editBtn = document.getElementById('editExpenseBtn');
                const deleteForm = document.getElementById('deleteExpenseForm');
                
                function closeModal(){
                    if(modal) {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                        actionsDiv.classList.add('hidden');
                    }
                }
                const deleteConfirmModal = document.getElementById('deleteConfirmModal');
                const deleteConfirmOverlay = document.getElementById('deleteConfirmOverlay');
                const closeDeleteConfirm = document.getElementById('closeDeleteConfirm');
                const cancelDelete = document.getElementById('cancelDelete');
                const confirmDelete = document.getElementById('confirmDelete');

                function openDeleteModal() {
                    if(deleteConfirmModal) {
                        deleteConfirmModal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                }
                function closeDeleteModal() {
                    if(deleteConfirmModal) {
                        deleteConfirmModal.classList.add('hidden');
                        document.body.style.overflow = 'auto'; // assuming expense details modal is also closed or handles scroll
                        // If expense details model is still open, we might want to keep scroll hidden?
                        // But expense details modal sets scroll hidden too.
                        // Let's just restore 'hidden' if details modal is open.
                        if(modal && !modal.classList.contains('hidden')) {
                            document.body.style.overflow = 'hidden';
                        }
                    }
                }

                if(deleteBtn) {
                     deleteBtn.addEventListener('click', function(e){
                        e.preventDefault();
                        openDeleteModal();
                     });
                }
                if(closeDeleteConfirm) closeDeleteConfirm.addEventListener('click', closeDeleteModal);
                if(cancelDelete) cancelDelete.addEventListener('click', closeDeleteModal);
                if(deleteConfirmOverlay) deleteConfirmOverlay.addEventListener('click', closeDeleteModal);
                if(confirmDelete) confirmDelete.addEventListener('click', function(){
                    confirmDelete.disabled = true;
                    confirmDelete.textContent = 'Deleting...';
                    deleteForm.submit();
                });



                if(overlay) overlay.addEventListener('click', closeModal);
                if(closeIcon) closeIcon.addEventListener('click', closeModal);
                if(closeBtn) closeBtn.addEventListener('click', closeModal);
                document.addEventListener('keydown', function(e){ if(e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });

                document.addEventListener('click', function(e){
                    const item = e.target.closest('.expense-item');
                    if(item){
                        const sharesRaw = item.dataset.shares;
                        if(sharesRaw && modal){
                            try {
                                const shares = JSON.parse(sharesRaw);
                                list.innerHTML = '';
                                
                                titleEl.innerHTML = (item.dataset.title || 'Expense') + (item.dataset.isEdited == '1' ? ' <span class="text-[10px] text-slate-400 font-normal italic inline-block transform translate-y-[-2px]">(edited)</span>' : '');
                                dateEl.textContent = item.dataset.date || '';
                                paidByEl.textContent = item.dataset.paidBy || 'Unknown';
                                const totalAmount = parseFloat(item.dataset.amount || 0).toFixed(2);
                                amountEl.textContent = '₹' + totalAmount;
                                
                                // Show actions if owner
                                const creatorId = item.dataset.createdBy;
                                if(currentUserId && creatorId && currentUserId == creatorId){
                                    actionsDiv.classList.remove('hidden');
                                    actionsDiv.style.display = 'grid'; // ensure grid
                                    // Set delete form action
                                    deleteForm.action = "{{ url('/expense-management/expenses') }}/" + item.dataset.id;
                                    // Set edit listener
                                    editBtn.onclick = function(){
                                        // TODO: Open edit modal
                                        openEditModal(item);
                                    };
                                } else {
                                    actionsDiv.classList.add('hidden');
                                    actionsDiv.style.display = 'none';
                                }

                                let hasItems = false;
                                for(let [name, amount] of Object.entries(shares)){
                                    if(Math.abs(amount) < 0.01) continue;
                                    hasItems = true;
                                    const shareAmt = parseFloat(amount).toFixed(2);
                                    
                                    // Find member details
                                    const m = groupMembers.find(gm => gm.name === name);
                                    const avatar = m && m.avatar ? `<img src="${m.avatar}" class="w-8 h-8 rounded-full object-cover border border-slate-100">` : `<div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs border border-slate-200">${name.charAt(0).toUpperCase()}</div>`;
                                    const row = document.createElement('div');
                                    row.className = 'flex items-center justify-between p-3 rounded-xl bg-white border border-slate-100';
                                    
                                    row.innerHTML = `
                                        <div class="flex items-center gap-3">
                                            ${avatar}
                                            <span class="font-bold text-slate-700 text-sm">${name}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-bold text-slate-700">₹${shareAmt}</span>
                                        </div>
                                    `;
                                    list.appendChild(row);
                                }
                                if(!hasItems){
                                    list.innerHTML = '<p class="text-center text-slate-400 text-sm">No split details available</p>';
                                }

                                modal.classList.remove('hidden');
                                document.body.style.overflow = 'hidden';

                            } catch(err){ console.error('Error parsing expense data', err); }
                        }
                    }
                });
            })();
        </script>
        @include('partials.footer-modern')
@endsection