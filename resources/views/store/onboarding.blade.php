@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-8">
        <x-icon name="check-circle" class="mx-auto h-16 w-16 text-green-500" />
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
                    <x-icon name="book" class="h-8 w-8 text-blue-500" />
                    <div class="ml-3">
                        <h3 class="text-md font-medium text-gray-800 group-hover:text-blue-600">Documentation</h3>
                        <p class="text-sm text-gray-600">Learn how to use all features</p>
                    </div>
                </div>
            </a>
            
            <a href="#" class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <x-icon name="users" class="h-8 w-8 text-blue-500" />
                    <div class="ml-3">
                        <h3 class="text-md font-medium text-gray-800 group-hover:text-blue-600">Community</h3>
                        <p class="text-sm text-gray-600">Get help from other store owners</p>
                    </div>
                </div>
            </a>
            
            <a href="#" class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <x-icon name="help-circle" class="h-8 w-8 text-blue-500" />
                    <div class="ml-3">
                        <h3 class="text-md font-medium text-gray-800 group-hover:text-blue-600">Tips & Tricks</h3>
                        <p class="text-sm text-gray-600">Learn best practices for your store</p>
                    </div>
                </div>
            </a>
            
            <a href="#" class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <x-icon name="support" class="h-8 w-8 text-blue-500" />
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