@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-4">Create an account</h2>
    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <input type="hidden" name="redirect" value="{{ request()->query('redirect') }}" />
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Name</label>
            <input name="name" required class="w-full px-3 py-2 border rounded" />
        </div>
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input name="email" type="email" required class="w-full px-3 py-2 border rounded" />
        </div>
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Password</label>
            <input name="password" type="password" required class="w-full px-3 py-2 border rounded" />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Confirm Password</label>
            <input name="password_confirmation" type="password" required class="w-full px-3 py-2 border rounded" />
        </div>
        <div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Register</button>
        </div>
    </form>
</div>
@endsection
