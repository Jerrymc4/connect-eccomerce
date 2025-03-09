@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Billing Information</h1>
        <p class="text-gray-600 mt-1">Selected plan: <strong>{{ $plan->name }}</strong> ({{ $plan->formattedPrice() }}/{{ $plan->billing_period }})</p>
    </div>

    <div class="flex justify-center mb-6">
        <div class="inline-flex rounded-md shadow-sm">
            <span class="relative z-0 inline-flex">
                <div class="flex items-center bg-gray-200 rounded-md py-1 px-4 text-gray-600">
                    <span class="flex h-6 w-6 rounded-full bg-green-500 text-white justify-center items-center mr-2">
                        <x-icon name="check" class="w-4 h-4" />
                    </span>
                    <span>Plan</span>
                </div>
                <div class="flex items-center bg-gray-200 rounded-md py-1 px-4 text-gray-600 ml-1">
                    <span class="flex h-6 w-6 rounded-full bg-green-500 text-white justify-center items-center mr-2">
                        <x-icon name="check" class="w-4 h-4" />
                    </span>
                    <span>Account</span>
                </div>
                <div class="flex items-center bg-blue-600 rounded-md py-1 px-4 text-white ml-1">
                    <span class="flex h-6 w-6 rounded-full bg-white text-blue-600 justify-center items-center mr-2">3</span>
                    <span>Billing</span>
                </div>
                <div class="flex items-center bg-gray-100 rounded-md py-1 px-4 text-gray-400 ml-1">
                    <span class="flex h-6 w-6 rounded-full bg-gray-300 text-gray-600 justify-center items-center mr-2">4</span>
                    <span>Store</span>
                </div>
            </span>
        </div>
    </div>

    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <x-icon name="alert-triangle" class="h-5 w-5 text-yellow-400" />
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Demo Mode</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>This is a demo application. No actual charges will be processed.</p>
                    <p class="mt-1">In a production environment, this would integrate with Stripe or another payment processor.</p>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('register.process-billing') }}">
        @csrf

        <!-- Cardholder Name -->
        <div class="mb-4">
            <label for="cardholder_name" class="block text-sm font-medium text-gray-700">Cardholder Name</label>
            <input id="cardholder_name" type="text" name="cardholder_name" value="{{ old('cardholder_name') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>

        <!-- Card Information (in a real app, this would be Stripe Elements) -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Card Information</label>
            <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-md">
                <div class="h-8 w-full bg-gray-200 rounded animate-pulse"></div>
            </div>
            <p class="mt-2 text-xs text-gray-500">For demo purposes, no real payment is processed</p>
        </div>

        <!-- Billing Address -->
        <div class="mb-4">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Billing Address</h3>
            
            <!-- Country -->
            <div class="mb-2">
                <label for="country" class="block text-xs font-medium text-gray-500">Country</label>
                <select id="country" name="country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="US">United States</option>
                    <option value="CA">Canada</option>
                    <option value="UK">United Kingdom</option>
                    <!-- Add more countries as needed -->
                </select>
            </div>
            
            <!-- Address -->
            <div class="mb-2">
                <label for="address" class="block text-xs font-medium text-gray-500">Address</label>
                <input id="address" type="text" name="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            
            <!-- City, State, Zip in a row -->
            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label for="city" class="block text-xs font-medium text-gray-500">City</label>
                    <input id="city" type="text" name="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="state" class="block text-xs font-medium text-gray-500">State</label>
                    <input id="state" type="text" name="state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="zip" class="block text-xs font-medium text-gray-500">ZIP</label>
                    <input id="zip" type="text" name="zip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="mb-6 bg-gray-50 p-4 rounded-md">
            <h3 class="font-medium text-gray-900">Order Summary</h3>
            <div class="mt-2 flex justify-between text-sm">
                <span class="text-gray-500">{{ $plan->name }} ({{ $plan->billing_period }})</span>
                <span class="font-medium text-gray-900">{{ $plan->formattedPrice() }}</span>
            </div>
            <div class="mt-1 flex justify-between text-sm">
                <span class="text-gray-500">Tax</span>
                <span class="font-medium text-gray-900">$0.00</span>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-200 flex justify-between">
                <span class="font-medium text-gray-900">Total</span>
                <span class="font-bold text-gray-900">{{ $plan->formattedPrice() }}</span>
            </div>
        </div>

        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('register.account') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <x-icon name="chevron-left" class="w-4 h-4 mr-1" />
                Back to Account
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Continue to Store Setup
                <x-icon name="chevron-right" class="w-4 h-4 ml-1" />
            </button>
        </div>
    </form>
@endsection 