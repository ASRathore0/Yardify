@extends('layouts.expense')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-12 bg-gray-50">
    <!-- Card Container -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        
        <!-- Header / Visual -->
        <div class="bg-brand-600 p-8 flex justify-center pb-12 relative overflow-hidden">
             <!-- Background decoration -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
                </svg>
            </div>
            
            <div class="h-20 w-20 bg-white/20 backdrop-blur-sm text-white rounded-2xl flex items-center justify-center ring-4 ring-white/10 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <div class="px-8 pb-10 pt-4 text-center">
            @if(isset($status) && $status === 'already')
                <h1 class="text-2xl font-bold text-slate-900 mb-2">Already Member</h1>
                <p class="text-slate-500 mb-8 leading-relaxed">
                    You have already accepted the invitation to join this group.
                </p>
                <div class="bg-slate-50 rounded-xl p-4 mb-8 flex items-center justify-center gap-3">
                    <div class="bg-green-100 p-1.5 rounded-full text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-slate-700 font-medium">Successfully Joined</span>
                </div>
                <a href="{{ url('/') }}" class="inline-flex w-full justify-center items-center px-4 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-brand-600/20">
                    Return to Dashboard
                </a>

            @elseif(isset($status) && $status === 'needs_auth')
                <div class="-mt-12 mb-6 inline-block bg-white px-6 py-2 rounded-full shadow-sm border border-brand-50 relative z-20">
                    <span class="text-brand-600 font-semibold tracking-wide text-sm uppercase">Group Invitation</span>
                </div>
                
                <h1 class="text-3xl font-bold text-slate-900 mb-3 tracking-tight">Join {{ $group->name }}</h1>
                <p class="text-slate-500 mb-8 text-lg leading-relaxed">
                    You've been invited to collaborate and share expenses.
                </p>
                
                <div class="bg-brand-50 border border-brand-100 rounded-2xl p-4 mb-8">
                    <p class="text-xs font-semibold text-brand-500 uppercase tracking-wide mb-1">Invitation For</p>
                    <p class="text-slate-900 font-medium">{{ $invitation->email }}</p>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="flex w-full justify-center items-center gap-3 px-4 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-brand-600/30">
                        <span>Log In to Accept</span>
                    </a>
                    
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-slate-500">New around here?</span>
                        </div>
                    </div>

                    <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="flex w-full justify-center items-center gap-3 px-4 py-3.5 bg-white border-2 border-slate-100 hover:border-brand-100 hover:bg-brand-50 text-slate-700 font-semibold rounded-xl transition-all">
                        Create Account
                    </a>
                </div>

            @else
                <h1 class="text-2xl font-bold text-slate-900 mb-2">Invitation</h1>
                <p class="text-slate-600 mb-6">This invitation is for <strong class="text-brand-600">{{ $invitation->email }}</strong>.</p>
                <div class="bg-yellow-50 text-yellow-800 p-4 rounded-xl border border-yellow-100 mb-6 text-sm">
                    Please ensure you are logged in with the correct account to accept this invitation.
                </div>
                <a href="{{ route('login') }}" class="inline-flex w-full justify-center items-center px-4 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition-all">
                    Login
                </a>
            @endif
        </div>
    </div>
    
    <!-- Footer Help -->
    <div class="mt-8 text-center">
        <p class="text-slate-400 text-xs">
            © {{ date('Y') }} BookingYard. All rights reserved.
        </p>
    </div>
</div>
@endsection
