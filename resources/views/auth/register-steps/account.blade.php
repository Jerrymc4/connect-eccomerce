@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Create Your Account</h1>
        <p class="text-gray-600 mt-2 text-lg">
            Selected plan: <span class="text-primary-600 font-medium">{{ $plan->name }}</span>
            <span class="text-sm">({{ $plan->formattedPrice() }}/{{ $plan->billing_period }})</span>
        </p>
    </div>

    <!-- Progress Steps -->
    <div class="flex justify-center mb-8">
        <div class="flex items-center w-full max-w-3xl">
            <div class="flex-1 relative">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-500 rounded-full">
                        <x-icons.check class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-600">Plan</p>
                        <p class="text-xs text-gray-500">Selected</p>
                    </div>
                </div>
                <div class="w-full h-1 bg-green-500 absolute top-5 left-0 -z-10"></div>
            </div>
            
            <div class="flex-1 relative">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary-600 rounded-full">
                        <span class="text-white font-semibold">2</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-primary-600">Account</p>
                        <p class="text-xs text-gray-500">Your details</p>
                    </div>
                </div>
                <div class="w-full h-1 bg-gray-200 absolute top-5 left-0 -z-10"></div>
            </div>
            
            <div class="flex-1">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-200 rounded-full">
                        <span class="text-gray-600 font-semibold">3</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600">Store</p>
                        <p class="text-xs text-gray-500">Setup shop</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-xl mx-auto">
        <form method="POST" action="{{ route('register.create-account') }}" class="bg-white shadow-lg rounded-2xl p-8">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-icons.user class="text-gray-400" />
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="block w-full pl-10 rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm
                            @error('name') border-red-300 text-red-900 placeholder-red-300 @enderror"
                        placeholder="John Doe">
                </div>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-icons.mail class="text-gray-400" />
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="block w-full pl-10 rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm
                            @error('email') border-red-300 text-red-900 placeholder-red-300 @enderror"
                        placeholder="you@example.com">
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-icons.lock class="text-gray-400" />
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full pl-10 rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm
                            @error('password') border-red-300 text-red-900 placeholder-red-300 @enderror"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-8">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-icons.lock class="text-gray-400" />
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="block w-full pl-10 rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                        placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('register.plans') }}" 
                    class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <x-icons.chevron-left class="mr-2" />
                    Back to Plans
                </a>
                <button type="submit" 
                    class="bg-gradient-to-r from-primary-600 to-primary-500 text-white px-6 py-3 rounded-xl text-sm font-semibold
                        shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                    Continue to {{ $plan->price > 0 ? 'Billing' : 'Store Setup' }}
                    <span aria-hidden="true" class="ml-2">→</span>
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-700">
                    Sign in instead
                </a>
            </p>
        </div>
    </div>
@endsection 