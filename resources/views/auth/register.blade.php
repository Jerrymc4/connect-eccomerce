@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Create a new account</h1>
        <p class="mt-2 text-sm text-gray-600">
            Or
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                sign in to your existing account
            </a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <div class="mt-1">
                <input id="name" name="name" type="text" autocomplete="name" required value="{{ old('name') }}" 
                    class="admin-input @error('name') border-red-500 @enderror">
            </div>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

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
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1">
                <input id="password" name="password" type="password" autocomplete="new-password" required
                    class="admin-input @error('password') border-red-500 @enderror">
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <div class="mt-1">
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                    class="admin-input">
            </div>
        </div>

        <div>
            <label for="store_name" class="block text-sm font-medium text-gray-700 mb-1">Store Name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-icon name="shopping-bag" class="h-5 w-5 text-gray-400" />
                </div>
                <input id="store_name" name="store_name" type="text" required value="{{ old('store_name') }}" 
                    class="block w-full pl-10 rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm
                        @error('store_name') border-red-300 text-red-900 placeholder-red-300 @enderror"
                    placeholder="Your store name">
                <p class="mt-1 text-xs text-gray-500">This will be the name of your store. You can change it later.</p>
            </div>
            @error('store_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="w-full admin-button">
                Register
            </button>
        </div>
    </form>

    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">
                    Or continue with
                </span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('auth.google') }}" 
                class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm 
                    bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors duration-200">
                <x-icon name="chrome" class="h-5 w-5 mr-2" />
                Sign up with Google
            </a>
        </div>
    </div>
@endsection 