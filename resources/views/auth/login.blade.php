@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Sign in to your account</h1>
        <p class="mt-2 text-gray-600 text-lg">
            Or
            <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-700">
                create a new account
            </a>
        </p>
    </div>

    <div class="max-w-xl mx-auto">
        <form method="POST" action="{{ route('login') }}" class="bg-white shadow-lg rounded-2xl p-8 space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-icons.mail class="text-gray-400" />
                    </div>
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" 
                        class="block w-full pl-10 rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm
                            @error('email') border-red-300 text-red-900 placeholder-red-300 @enderror"
                        placeholder="you@example.com">
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-icons.lock class="text-gray-400" />
                    </div>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="block w-full pl-10 rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm
                            @error('password') border-red-300 text-red-900 placeholder-red-300 @enderror"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-primary-600 hover:text-primary-700">
                        Forgot your password?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-primary-600 to-primary-500 text-white px-6 py-3 rounded-xl text-sm font-semibold
                        shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                    Sign in
                </button>
            </div>
        </form>

        <div class="mt-8">
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
                    <x-icons.google class="mr-2" />
                    Sign in with Google
                </a>
            </div>
        </div>
    </div>
@endsection 