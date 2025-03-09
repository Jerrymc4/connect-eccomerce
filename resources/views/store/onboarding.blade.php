@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-8">
        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h1 class="mt-4 text-2xl font-bold text-gray-800">Congratulations!</h1>
        <p class="mt-2 text-gray-600">Your store <strong>{{ $store->name }}</strong> has been created successfully.</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Next Steps</h2>
        
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-1">
                    <span class="flex h-7 w-7 bg-blue-500 text-white rounded-full font-medium justify-center items-center">1</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-md font-medium text-gray-800">Visit your store dashboard</h3>
                    <p class="mt-1 text-sm text-gray-600">Access your store at <a href="https://{{ $store->domains->first()->domain }}" class="text-blue-600 hover:text-blue-800 underline" target="_blank">{{ $store->domains->first()->domain }}</a></p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-1">
                    <span class="flex h-7 w-7 bg-blue-500 text-white rounded-full font-medium justify-center items-center">2</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-md font-medium text-gray-800">Customize your store</h3>
                    <p class="mt-1 text-sm text-gray-600">Add your logo, choose a theme, and configure your store settings.</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-1">
                    <span class="flex h-7 w-7 bg-blue-500 text-white rounded-full font-medium justify-center items-center">3</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-md font-medium text-gray-800">Add your products</h3>
                    <p class="mt-1 text-sm text-gray-600">Start adding products to your store catalog.</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-1">
                    <span class="flex h-7 w-7 bg-blue-500 text-white rounded-full font-medium justify-center items-center">4</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-md font-medium text-gray-800">Set up payments</h3>
                    <p class="mt-1 text-sm text-gray-600">Configure your payment methods and start accepting orders.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Resources</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="#" class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-md font-medium text-gray-800 group-hover:text-blue-600">Documentation</h3>
                        <p class="text-sm text-gray-600">Learn how to use all features</p>
                    </div>
                </div>
            </a>
            
            <a href="#" class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-md font-medium text-gray-800 group-hover:text-blue-600">Community</h3>
                        <p class="text-sm text-gray-600">Get help from other store owners</p>
                    </div>
                </div>
            </a>
            
            <a href="#" class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-md font-medium text-gray-800 group-hover:text-blue-600">Tips & Tricks</h3>
                        <p class="text-sm text-gray-600">Learn best practices for your store</p>
                    </div>
                </div>
            </a>
            
            <a href="#" class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-md font-medium text-gray-800 group-hover:text-blue-600">Support</h3>
                        <p class="text-sm text-gray-600">Get help from our support team</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="flex justify-center mt-8">
        <form method="POST" action="{{ route('store.onboarding.complete') }}">
            @csrf
            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Go to My Store Dashboard
            </button>
        </form>
    </div>
@endsection 