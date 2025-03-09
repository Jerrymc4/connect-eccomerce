@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Create Your Account</h1>
        <p class="text-gray-600 mt-1">Selected plan: <strong>{{ $plan->name }}</strong> ({{ $plan->formattedPrice() }}/{{ $plan->billing_period }})</p>
    </div>

    <div class="flex justify-center mb-6">
        <div class="inline-flex rounded-md shadow-sm">
            <span class="relative z-0 inline-flex">
                <div class="flex items-center bg-gray-200 rounded-md py-1 px-4 text-gray-600">
                    <span class="flex h-6 w-6 rounded-full bg-green-500 text-white justify-center items-center mr-2">✓</span>
                    <span>Plan</span>
                </div>
                <div class="flex items-center bg-blue-600 rounded-md py-1 px-4 text-white ml-1">
                    <span class="flex h-6 w-6 rounded-full bg-white text-blue-600 justify-center items-center mr-2">2</span>
                    <span>Account</span>
                </div>
                <div class="flex items-center bg-gray-100 rounded-md py-1 px-4 text-gray-400 ml-1">
                    <span class="flex h-6 w-6 rounded-full bg-gray-300 text-gray-600 justify-center items-center mr-2">3</span>
                    <span>Store</span>
                </div>
            </span>
        </div>
    </div>

    <form method="POST" action="{{ route('register.create-account') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm
                         @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm
                         @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm
                         @error('password') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>

        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('register.plans') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Back to Plans
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Continue to {{ $plan->price > 0 ? 'Billing' : 'Store Setup' }} &rarr;
            </button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm text-gray-500">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Log in</a>
        </p>
    </div>
@endsection 