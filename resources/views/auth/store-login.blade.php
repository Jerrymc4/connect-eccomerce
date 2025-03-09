@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Sign in to {{ $store->name }}</h1>
        <p class="mt-2 text-sm text-gray-600">
            Enter your credentials to access this store
        </p>
    </div>

    <form method="POST" action="{{ route('store.login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-icon name="mail" class="h-5 w-5 text-gray-400" />
                </div>
                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                    class="block w-full pl-10 rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm
                        @error('email') border-red-300 text-red-900 placeholder-red-300 @enderror"
                    placeholder="Email address">
            </div>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-icon name="lock" class="h-5 w-5 text-gray-400" />
                </div>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    class="block w-full pl-10 rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm
                        @error('password') border-red-300 text-red-900 placeholder-red-300 @enderror"
                    placeholder="Password">
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-900">
                    Remember me
                </label>
            </div>
        </div>

        <div>
            <button type="submit" class="w-full admin-button">
                Sign in
            </button>
        </div>
    </form>
@endsection 