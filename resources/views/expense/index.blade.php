@extends('layouts.expense')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Expense Dashboard</h1>
            <p class="text-slate-500 mt-1">Manage shared living costs and track roommate spending.</p>
        </div>
        <div>
            <a href="{{ route('expense.groups.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Create New Group
            </a>
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
            <p class="text-3xl font-black text-indigo-600 mt-2">₹{{ number_format($total, 2) }}</p>
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
                <div class="group bg-white border border-slate-200 rounded-3xl p-6 transition-all duration-300 hover:border-indigo-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex justify-between items-start mb-6">
                        <div class="h-12 w-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 font-bold text-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
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
                        <a href="{{ route('expense.groups.show', ['group' => $g['id']]) }}" 
                           class="flex justify-center items-center py-2.5 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-black transition-colors">
                            Open Group
                        </a>
                        <a href="{{ url('/expense-management/groups/'.$g['id'].'/report') }}" 
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
@endsection