@extends('layouts.app')

@section('title', 'HR Admin Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">HR Admin Login</h1>
    <form action="{{ route('hr.login.submit') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" name="email" id="email" class="w-full border rounded p-2" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password:</label>
            <input type="password" name="password" id="password" class="w-full border rounded p-2" required>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember" class="form-checkbox" {{ old('remember') ? 'checked' : '' }}>
                <span class="ml-2">Remember me</span>
            </label>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
    </form>
    <p class="mt-4 text-sm text-center">
        Don't have an account? <a href="{{ route('hr.register') }}" class="text-blue-500">Register here</a>.
    </p>
</div>
@endsection
