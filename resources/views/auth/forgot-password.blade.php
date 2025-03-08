@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Forgot your password?</h1>
        <p class="mt-2 text-sm text-gray-600">
            No problem. Just let us know your email address and we will email you a password reset link.
        </p>
    </div>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" 
                    class="admin-input @error('email') border-red-500 @enderror">
            </div>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="w-full admin-button">
                Email Password Reset Link
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
            Back to login
        </a>
    </div>
@endsection 