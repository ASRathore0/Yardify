@extends('layouts.expense')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12 text-center">
    @if(isset($status) && $status === 'already')
        <h1 class="text-2xl font-bold">Invitation already accepted</h1>
        <p class="mt-4 text-slate-500">This invitation was already accepted.</p>
        <div class="mt-6">
            <a href="{{ url('/') }}" class="px-4 py-2 bg-slate-800 text-white rounded-lg">Return Home</a>
        </div>
    @elseif(isset($status) && $status === 'needs_auth')
        <h1 class="text-2xl font-bold">Join {{ $group->name }}</h1>
        <p class="mt-3 text-slate-600">To accept the invitation for <strong>{{ $invitation->email }}</strong>, please login or register. After logging in you'll be added to the group automatically.</p>
        <div class="mt-6 flex justify-center gap-4">
            <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Login</a>
            <a href="{{ route('register') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="px-4 py-2 bg-white border rounded-lg">Register</a>
        </div>
        <p class="text-sm text-slate-400 mt-4">If you already have an account, use Login. Otherwise register and then return to this link.</p>
    @else
        <h1 class="text-2xl font-bold">Invitation</h1>
        <p class="mt-3 text-slate-600">This invitation is for <strong>{{ $invitation->email }}</strong>.</p>
        <p class="mt-4 text-slate-500">Unknown state. Please open the invitation link while logged in to accept.</p>
    @endif
</div>
@endsection
