@extends('auth.layouts.app')

@section('content')
    @php
        use App\Models\Plan;
    @endphp
    
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Set Up Your Store</h1>
        <p class="text-gray-600 mt-1">Almost done! Let's create your store.</p>
    </div>

    <div class="flex justify-center mb-6">
        <div class="inline-flex rounded-md shadow-sm">
            <span class="relative z-0 inline-flex">
                <div class="flex items-center bg-gray-200 rounded-md py-1 px-4 text-gray-600">
                    <span class="flex h-6 w-6 rounded-full bg-green-500 text-white justify-center items-center mr-2">✓</span>
                    <span>Plan</span>
                </div>
                <div class="flex items-center bg-gray-200 rounded-md py-1 px-4 text-gray-600 ml-1">
                    <span class="flex h-6 w-6 rounded-full bg-green-500 text-white justify-center items-center mr-2">✓</span>
                    <span>Account</span>
                </div>
                @if(session('selected_plan') && Plan::find(session('selected_plan'))->price > 0)
                <div class="flex items-center bg-gray-200 rounded-md py-1 px-4 text-gray-600 ml-1">
                    <span class="flex h-6 w-6 rounded-full bg-green-500 text-white justify-center items-center mr-2">✓</span>
                    <span>Billing</span>
                </div>
                @endif
                <div class="flex items-center bg-blue-600 rounded-md py-1 px-4 text-white ml-1">
                    <span class="flex h-6 w-6 rounded-full bg-white text-blue-600 justify-center items-center mr-2">
                        {{ session('selected_plan') && Plan::find(session('selected_plan'))->price > 0 ? '4' : '3' }}
                    </span>
                    <span>Store</span>
                </div>
            </span>
        </div>
    </div>

    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-md p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Your Store Domain</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Your store name will be used to create your unique subdomain (e.g., "your-store.{{ config('app.url_base', 'example.com') }}").</p>
                    <p class="mt-1">You can set up a custom domain later from your store settings.</p>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('register.create-store') }}">
        @csrf

        <!-- Store Name -->
        <div class="mb-4">
            <label for="store_name" class="block text-sm font-medium text-gray-700">Store Name</label>
            <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm
                         @error('store_name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
            <div class="mt-1 text-sm text-gray-500">Your store subdomain: <span id="preview-domain" class="font-medium"></span>.{{ config('app.url_base', 'example.com') }}</div>
            @error('store_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Selected Plan: {{ $plan->name }}</h3>
                <ul class="text-sm text-gray-600 space-y-1 mb-4">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Up to {{ $plan->max_products }} products</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Up to {{ $plan->max_staff_accounts }} staff accounts</span>
                    </li>
                    @if($plan->has_custom_domain)
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Custom domain support</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="flex items-center justify-between mb-4">
            @if(session('selected_plan') && Plan::find(session('selected_plan'))->price > 0)
                <a href="{{ route('register.billing') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    &larr; Back to Billing
                </a>
            @else
                <a href="{{ route('register.account') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    &larr; Back to Account
                </a>
            @endif
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Create Store &rarr;
            </button>
        </div>
    </form>

    <script>
        // Simple slug generator for preview
        document.addEventListener('DOMContentLoaded', function () {
            const storeNameInput = document.getElementById('store_name');
            const previewDomain = document.getElementById('preview-domain');
            
            function updateDomainPreview() {
                const storeName = storeNameInput.value;
                const slug = storeName.toLowerCase()
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');
                previewDomain.textContent = slug;
            }
            
            storeNameInput.addEventListener('input', updateDomainPreview);
            updateDomainPreview();
        });
    </script>
@endsection 