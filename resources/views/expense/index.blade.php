@extends('layouts.expense')

@section('content')
@include('partials.header')
@include('partials.sidebar')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<style>
    :root {
        --primary: #046c9f;
        --primary-dark: #035680;
        --accent: #f8fafc;
    }
    body { background-color: #f3f4f6; }

    /* Modern Hero */
    .dashboard-header {
        background: linear-gradient(135deg, #046c9f 0%, #034d71 100%);
        padding: 60px 0 90px 0;
        border-radius: 0 0 40px 40px;
    }

    /* Floating Stats Card */
    .stats-overlay {
        margin-top: -50px;
        position: relative;
        z-index: 10;
    }

    /* Group Card Styling */
    .group-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .group-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        border-color: var(--primary);
    }

    /* Custom Scrollbar for better UX */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }
</style>

<!-- Hero Section -->
<section class="dashboard-header text-white">
    <div class="max-w-7xl mx-auto px-6 mt-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="font-sans max-w-md mx-auto text-center">
                <h2 class="text-2xl font-medium tracking-tight leading-tight text-white">Manage Expenses</h2>
            </div>
            <div class="w-full flex justify-center">
                <button onclick="document.getElementById('createGroupModal').classList.remove('hidden')" 
                   class="inline-flex items-center px-6 py-3 bg-white text-[#046c9f] rounded-2xl font-bold shadow-xl hover:bg-blue-50 transition-all transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    New Group
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Area -->
<div class="max-w-7xl mx-auto px-6 pb-28">
    
    <!-- Stats Overlay -->
    <div class="stats-overlay grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        @php $total = collect($groups)->flatMap(fn($g) => $g['expenses'])->sum('amount'); @endphp
        
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="bg-blue-50 p-4 rounded-2xl text-[#046c9f]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Active Groups</p>
                <p class="text-2xl font-black text-slate-800">{{ count($groups) }}</p>
            </div>
        </div>

        <!-- <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-4 md:col-span-2">
            <div class="bg-green-50 p-4 rounded-2xl text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Total Combined Spend</p>
                <p class="text-3xl font-black text-slate-900">₹{{ number_format($total, 2) }}</p>
            </div>
        </div> -->
    </div>

    <!-- Groups Section -->
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-xl font-bold text-slate-800 flex items-center">
            Your Workspaces
            <span class="ml-3 px-3 py-1 bg-slate-200 text-slate-600 text-xs rounded-full">{{ count($groups) }} Total</span>
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($groups as $g)
            @php 
                $gTotal = collect($g['expenses'])->sum('amount'); 
                $isMember = collect($g['members'])->contains(fn($m) => data_get($m, 'id') == auth()->id());
                $isOwner = isset($g['created_by']) && $g['created_by'] == auth()->id();
            @endphp
            
            <div onclick="window.location.href='{{ route('expense.groups.show', ['group' => $g['id']]) }}'" 
                 class="group-card relative bg-white rounded-[2rem] p-7 cursor-pointer overflow-hidden flex flex-col h-full">
                
                @if(!empty($g['deleted']))
                    <div class="absolute top-4 right-4 bg-red-100 text-red-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter">Deleted</div>
                @else
                    <div class="absolute top-4 right-4 bg-blue-50 text-[#046c9f] px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter">Active</div>
                @endif

                <div class="flex items-center mb-6">
                    <div class="h-14 w-14 bg-gradient-to-br from-[#046c9f] to-blue-400 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-blue-100">
                        {{ substr($g['name'], 0, 1) }}
                    </div>
                    <div class="ml-4 overflow-hidden">
                        <h4 class="text-xl font-bold text-slate-800 truncate">{{ $g['name'] }}</h4>
                        <div class="flex items-center text-slate-400 text-xs mt-1">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a7 7 0 00-7 7v1h11v-1a7 7 0 00-7-7z"/></svg>
                            {{ count($g['members']) }} members
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl p-4 mb-6">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Group Spending</p>
                    <p class="text-2xl font-black text-slate-900">₹{{ number_format($gTotal, 2) }}</p>
                </div>

                <div class="mt-auto flex items-center justify-between">
                    <div class="flex -space-x-2">
                        @foreach(array_slice($g['members'], 0, 3) as $member)
                             <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600" title="{{ $member['name'] ?? 'User' }}">
                                {{ substr($member['name'] ?? 'U', 0, 1) }}
                             </div>
                        @endforeach
                        @if(count($g['members']) > 3)
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-400">
                                +{{ count($g['members']) - 3 }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-2">
                        @if(empty($g['deleted']))
                            <div class="relative">
                                <button type="button" onclick="event.stopPropagation(); toggleGroupMenu({{ $g['id'] }})" class="p-2 hover:bg-slate-100 rounded-xl transition-colors">
                                    <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </button>
                                <div id="groupMenu-{{ $g['id'] }}" class="group-menu hidden absolute right-0 bottom-full mb-2 w-48 bg-white border border-slate-100 rounded-2xl shadow-2xl z-50 overflow-hidden">
                                    <a href="{{ url('/expense-management/groups/'.$g['id'].'/report') }}" onclick="event.stopPropagation()" class="block px-4 py-3 text-sm text-gray-700 hover:bg-slate-50 border-b border-slate-50">View Analytics</a>
                                    @if($isOwner)
                                        <button type="button" onclick="event.stopPropagation(); toggleGroupMenu({{ $g['id'] }}); confirmDeleteOwner({{ $g['id'] }}, {{ $isMember ? 'true' : 'false' }})" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50">Delete Group</button>
                                        <form id="deleteForm-{{ $g['id'] }}" action="{{ url('/expense-management/groups/'.$g['id']) }}" method="POST" style="display:none">@csrf @method('DELETE')</form>
                                    @else
                                        <button type="button" onclick="event.stopPropagation(); toggleGroupMenu({{ $g['id'] }}); confirmLeave({{ $g['id'] }})" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-slate-50">Leave Group</button>
                                    @endif
                                    <form id="leaveForm-{{ $g['id'] }}" action="{{ url('/expense-management/groups/'.$g['id'].'/leave') }}" method="POST" style="display:none">@csrf</form>
                                </div>
                            </div>
                            <a href="{{ route('expense.groups.show', ['group' => $g['id']]) }}" onclick="event.stopPropagation()"
                               class="bg-slate-900 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-black transition-all">
                                Open
                            </a>
                        @else
                             <button type="button" onclick="event.stopPropagation(); confirmLeave({{ $g['id'] }})"
                                    class="px-4 py-2 bg-white border border-red-100 text-red-600 rounded-xl font-bold text-xs hover:bg-red-50 transition-colors">
                                Remove List
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 bg-white border-2 border-dashed border-slate-200 rounded-[2.5rem] flex flex-col items-center justify-center text-center">
                <div class="bg-slate-50 p-6 rounded-full mb-4">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">No Groups Found</h3>
                <p class="text-slate-500 max-w-xs mt-2">Get started by creating your first expense group to track costs with roommates.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal: Create Group -->
<div id="createGroupModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('createGroupModal').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-all animate-in fade-in zoom-in duration-200">
        <div class="px-8 pt-8 pb-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-black text-slate-900">Create Group</h3>
                    <p class="text-sm text-slate-500">Organize your shared expenses</p>
                </div>
                <button onclick="document.getElementById('createGroupModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-slate-100 p-2 rounded-full">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <form action="{{ route('expense.groups.store') }}" method="POST" id="createGroupForm" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Group Name</label>
                    <input type="text" name="name" required class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-4 px-5 text-sm focus:bg-white focus:ring-2 focus:ring-[#046c9f] focus:border-transparent transition-all" placeholder="e.g. Apartment 4B, Road Trip">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Description (Optional)</label>
                    <textarea name="description" rows="3" class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-4 px-5 text-sm focus:bg-white focus:ring-2 focus:ring-[#046c9f] focus:border-transparent transition-all resize-none" placeholder="What are these expenses for?"></textarea>
                </div>
            </form>
        </div>
        <div class="bg-slate-50 px-8 py-6 flex gap-3">
            <button type="submit" form="createGroupForm" class="flex-1 bg-[#046c9f] text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-100 hover:bg-[#035680] transition-all">Create Group</button>
            <button type="button" onclick="document.getElementById('createGroupModal').classList.add('hidden')" class="px-6 bg-white text-slate-600 font-bold rounded-2xl border border-slate-200 hover:bg-slate-100 transition-all">Cancel</button>
        </div>
    </div>
</div>

<!-- Modal: Confirm Delete (Redesigned) -->
<div id="confirmDeleteModal" class="hidden fixed inset-0 z-[70] flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-red-900/20 backdrop-blur-md transition-opacity" onclick="closeConfirmDelete()"></div>
    <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden animate-in slide-in-from-bottom-4 duration-200">
        <div class="p-8 text-center">
            <div class="w-20 h-20 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-2xl font-black text-slate-900 mb-2" id="confirm-delete-title">Are you sure?</h3>
            <p id="confirmDeleteMessage" class="text-slate-500">This action cannot be undone.</p>
        </div>
        <div class="bg-slate-50 p-6 flex flex-col gap-3">
            <button id="primaryActionBtn" type="button" onclick="performPrimaryAction()" class="w-full py-4 bg-red-600 text-white rounded-2xl font-bold hover:bg-red-700 transition-all">Confirm Action</button>
            <button onclick="closeConfirmDelete()" class="w-full py-4 text-slate-600 font-bold hover:bg-slate-200 rounded-2xl transition-all">Keep Group</button>
        </div>
    </div>
</div>
 

<script>
    /* 
       Keep all your existing JS logic exactly as it was. 
       The UI elements above use the same IDs and onclick handlers.
    */
    let _confirmGroupId = null;
    let _confirmFlow = null; 

    function openConfirm(flow, groupId, opts = {}){
        _confirmGroupId = groupId;
        _confirmFlow = flow;
        const msgEl = document.getElementById('confirmDeleteMessage');
        const primary = document.getElementById('primaryActionBtn');
        
        if(flow === 'leave-only'){
            msgEl.textContent = 'You will no longer see or be billed for future expenses in this group.';
            primary.textContent = 'Leave Group';
            primary.className = 'w-full py-4 bg-[#046c9f] text-white rounded-2xl font-bold hover:bg-[#035680] transition-all';
        } else if(flow === 'leave-and-delete'){
            msgEl.textContent = 'You are the owner. This will remove the group for ALL members permanently.';
            primary.textContent = 'Leave & Delete';
            primary.className = 'w-full py-4 bg-red-600 text-white rounded-2xl font-bold hover:bg-red-700 transition-all';
        } else { 
            msgEl.textContent = 'Are you sure you want to delete this group? This action cannot be undone.';
            primary.textContent = 'Delete Permanently';
            primary.className = 'w-full py-4 bg-red-600 text-white rounded-2xl font-bold hover:bg-red-700 transition-all';
        }
        document.getElementById('confirmDeleteModal').classList.remove('hidden');
    }

    function confirmDeleteOwner(groupId, isMember){ openConfirm(isMember ? 'leave-and-delete' : 'delete-only', groupId); }
    function confirmLeave(groupId){ openConfirm('leave-only', groupId); }
    function closeConfirmDelete(){ document.getElementById('confirmDeleteModal').classList.add('hidden'); }

    async function performPrimaryAction(){
        if(!_confirmGroupId || !_confirmFlow) return closeConfirmDelete();
        const g = _confirmGroupId;
        if(_confirmFlow === 'leave-only') return performLeaveOnly(g);
        if(_confirmFlow === 'leave-and-delete') return performLeaveThenDelete(g);
        if(_confirmFlow === 'delete-only') return performDeleteOnly(g);
    }

    async function performLeaveOnly(groupId){
        const leaveForm = document.getElementById('leaveForm-'+groupId);
        try {
            const fd = new FormData(leaveForm);
            const res = await fetch(leaveForm.action, { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } });
            if (res.ok) return location.reload();
            alert('Error leaving group');
        } catch(err){ console.error(err); }
    }

    async function performLeaveThenDelete(groupId){
        const leaveForm = document.getElementById('leaveForm-'+groupId);
        const deleteForm = document.getElementById('deleteForm-'+groupId);
        try {
            if (leaveForm){
                const fd = new FormData(leaveForm);
                await fetch(leaveForm.action, { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } });
            }
            if (deleteForm) deleteForm.submit();
        } catch(err){ console.error(err); }
    }

    async function performDeleteOnly(groupId){
        const deleteForm = document.getElementById('deleteForm-'+groupId);
        if (deleteForm) deleteForm.submit();
    }

    function toggleGroupMenu(groupId){
        const el = document.getElementById('groupMenu-'+groupId);
        const isHidden = el.classList.contains('hidden');
        closeAllGroupMenus();
        if (isHidden) el.classList.remove('hidden');
    }

    function closeAllGroupMenus(){
        document.querySelectorAll('.group-menu').forEach(el => el.classList.add('hidden'));
    }

    document.addEventListener('click', () => closeAllGroupMenus());
</script>
@include('partials.footer-modern')
<script src="js/script.js"></script>
<script src="js/script1.js"></script>
@endsection