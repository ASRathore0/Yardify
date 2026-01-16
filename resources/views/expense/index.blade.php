@extends('layouts.expense')

@section('content')
@include('partials.header')
@include('partials.sidebar')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<style>
    .expense-hero {
        background: #046c9f;
        color: #fff;
        padding: 80px 20px 40px;
        text-align: center;
        margin-top:2px;
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
    }
    .expense-hero h2 {
        font-size: 1.5rem;
        margin-bottom: rem;
        font-weight: 700;
        color: #fff;
    }
    .expense-hero p {
        font-size: 1.125rem;
        color: #d1d5db;
        max-width: 600px;
        margin: 0 auto;
    }
</style>

<section class="expense-hero">
    <div class="max-w-7xl mx-auto px-4">
        <h2>Expense Dashboard</h2>
        <p>Manage shared living costs and track roommate spending.</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 pb-28">
    
    <div class="flex justify-end mb-10">
        <div>
            <button onclick="document.getElementById('createGroupModal').classList.remove('hidden')" 
               class="inline-flex items-center px-6 py-3 bg-[#046c9f] border border-transparent rounded-xl font-bold text-white shadow-sm hover:bg-[#035680] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#046c9f] transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Create New Group
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Groups</p>
            <p class="text-3xl font-black text-slate-900 mt-2">{{ count($groups) }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow lg:col-span-2">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Combined Spend</p>
            @php $total = collect($groups)->flatMap(fn($g) => $g['expenses'])->sum('amount'); @endphp
            <p class="text-3xl font-black text-[#046c9f] mt-2">₹{{ number_format($total, 2) }}</p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <h3 class="text-xl font-bold text-slate-800">Your Groups</h3>
            <span class="text-sm text-slate-500">{{ count($groups) }} Folders</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($groups as $g)
                @php $gTotal = collect($g['expenses'])->sum('amount'); @endphp
                <div onclick="window.location.href='{{ route('expense.groups.show', ['group' => $g['id']]) }}'" class="group bg-white border border-slate-200 rounded-3xl p-6 transition-all duration-300 hover:border-[#046c9f] hover:shadow-xl hover:-translate-y-1 cursor-pointer">
                    <div class="flex justify-between items-start mb-6">
                        <div class="h-12 w-12 bg-[#e0f2fe] rounded-2xl flex items-center justify-center text-[#046c9f] font-bold text-xl group-hover:bg-[#046c9f] group-hover:text-white transition-colors">
                            {{ substr($g['name'], 0, 1) }}
                        </div>
                        <div class="text-right">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase">Total Spend</span>
                            <span class="text-lg font-black text-slate-900">₹{{ number_format($gTotal, 2) }}</span>
                        </div>
                    </div>

                    <h4 class="text-lg font-bold text-slate-800 truncate">{{ $g['name'] }}</h4>
                    <p class="text-sm text-slate-500 mt-1 mb-6 flex items-center">
                        <svg class="w-4 h-4 mr-1 opacity-40" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a7 7 0 00-7 7v1h11v-1a7 7 0 00-7-7z"/></svg>
                        {{ count($g['members']) }} roommates
                    </p>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('expense.groups.show', ['group' => $g['id']]) }}" onclick="event.stopPropagation()"
                           class="flex justify-center items-center py-2.5 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-black transition-colors">
                            Open Group
                        </a>
                        <a href="{{ url('/expense-management/groups/'.$g['id'].'/report') }}" onclick="event.stopPropagation()"
                           class="flex justify-center items-center py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition-colors">
                            Report
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl flex flex-col items-center">
                    <p class="text-slate-400 font-medium">No groups found. Get started by creating your first group.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Create Group Modal -->
<div id="createGroupModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-900/75 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('createGroupModal').classList.add('hidden')"></div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            <div class="bg-white px-6 pt-6 pb-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-xl font-bold text-gray-900" id="modal-title">Create New Group</h3>
                    <button onclick="document.getElementById('createGroupModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form action="{{ route('expense.groups.store') }}" method="POST" id="createGroupForm">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Group Name</label>
                            <input type="text" name="name" id="name" required 
                                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#046c9f] focus:ring-[#046c9f] sm:text-sm py-3 px-4 bg-gray-50 border transition-colors hover:bg-white" 
                                placeholder="e.g. Summer Trip, Office Lunch">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <textarea name="description" id="description" rows="3" 
                                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#046c9f] focus:ring-[#046c9f] sm:text-sm py-3 px-4 bg-gray-50 border transition-colors hover:bg-white resize-none" 
                                placeholder="What's this group for?"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                <button type="submit" form="createGroupForm" 
                    class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-[#046c9f] text-base font-bold text-white hover:bg-[#035680] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#046c9f] transition-all">
                    Create Group
                </button>
                <button type="button" onclick="document.getElementById('createGroupModal').classList.add('hidden')" 
                    class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-gray-200 shadow-sm px-6 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@include('partials.footer-mobile')
<script src="js/script.js"></script>
<script src="js/script1.js"></script>
@endsection