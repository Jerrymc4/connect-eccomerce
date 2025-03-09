@extends('layouts.app')

@section('full-width', true)

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-b from-blue-600 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div>
                    <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                        Launch your online store in minutes
                    </h1>
                    <p class="mt-6 text-xl text-blue-100 max-w-3xl">
                        Connect Commerce provides everything you need to create, manage, and grow your online business.
                        Our platform is designed for simplicity and scalability.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 shadow-lg">
                            Get started for free
                        </a>
                        <a href="#features" class="inline-flex items-center justify-center px-5 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-blue-700">
                            Learn more
                        </a>
                    </div>
                </div>
                <div class="mt-10 lg:mt-0 relative">
                    <div class="bg-white shadow-xl rounded-lg overflow-hidden transform rotate-1">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="aspect-w-16 aspect-h-9 bg-gray-50 rounded-lg overflow-hidden">
                                <div class="flex items-center justify-center h-64 bg-blue-50 text-blue-500">
                                    <svg class="h-24 w-24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative elements -->
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 hidden lg:block">
                        <svg width="404" height="404" fill="none" viewBox="0 0 404 404" aria-hidden="true" class="text-blue-400 opacity-20">
                            <defs>
                                <pattern id="85737c0e-0916-41d7-917f-596dc7edfa27" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                    <rect x="0" y="0" width="4" height="4" class="text-blue-400" fill="currentColor" />
                                </pattern>
                            </defs>
                            <rect width="404" height="404" fill="url(#85737c0e-0916-41d7-917f-596dc7edfa27)" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="bg-blue-50 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <dt class="text-sm font-medium text-blue-500 truncate">Total Stores</dt>
                        <dd class="mt-1 text-3xl font-semibold text-blue-800">5,000+</dd>
                    </div>
                </div>
                <div class="bg-blue-50 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <dt class="text-sm font-medium text-blue-500 truncate">Products Sold</dt>
                        <dd class="mt-1 text-3xl font-semibold text-blue-800">1M+</dd>
                    </div>
                </div>
                <div class="bg-blue-50 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <dt class="text-sm font-medium text-blue-500 truncate">Customer Satisfaction</dt>
                        <dd class="mt-1 text-3xl font-semibold text-blue-800">99.8%</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Features</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Everything you need to succeed online
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Our platform provides all the tools you need to build and grow your e-commerce business.
                </p>
            </div>

            <div class="mt-16">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <!-- Feature 1 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Multi-store Platform</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Manage multiple stores from a single dashboard. Each store has its own domain, products, and customers.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Secure Payments</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Accept payments from customers worldwide with our secure payment processing system.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Customer Management</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Build relationships with your customers through our integrated CRM tools.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Analytics & Reporting</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Gain insights into your business with detailed analytics and reporting tools.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <div id="pricing" class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Pricing</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Plans for businesses of all sizes
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Choose the right plan to power your online business. All plans include core features.
                </p>
            </div>
            
            <div class="mt-16 space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Free Plan -->
                <div class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900">Free</h3>
                        <p class="mt-4 flex items-baseline text-gray-900">
                            <span class="text-5xl font-extrabold tracking-tight">$0</span>
                            <span class="ml-1 text-xl font-semibold">/month</span>
                        </p>
                        <p class="mt-6 text-gray-500">Perfect for getting started with e-commerce.</p>
                        
                        <ul role="list" class="mt-6 space-y-6">
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="ml-3 text-gray-500">Up to 10 products</span>
                            </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="ml-3 text-gray-500">Basic online store</span>
                        </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                <span class="ml-3 text-gray-500">Email support</span>
                        </li>
                    </ul>
                    </div>
                    
                    <a href="{{ route('register') }}" class="mt-8 block w-full bg-blue-50 border border-blue-100 rounded-md py-2 text-sm font-semibold text-blue-600 text-center hover:bg-blue-100">
                        Get started
                    </a>
                </div>
                
                <!-- Starter Plan (Featured) -->
                <div class="relative p-8 bg-white border-2 border-blue-500 rounded-2xl shadow-lg flex flex-col">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="inline-flex px-4 py-1 rounded-full text-sm font-semibold tracking-wide uppercase bg-blue-100 text-blue-600">
                            Most Popular
                        </span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900">Starter</h3>
                        <p class="mt-4 flex items-baseline text-gray-900">
                            <span class="text-5xl font-extrabold tracking-tight">$29</span>
                            <span class="ml-1 text-xl font-semibold">/month</span>
                        </p>
                        <p class="mt-6 text-gray-500">For small businesses ready to grow.</p>
                        
                        <ul role="list" class="mt-6 space-y-6">
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="ml-3 text-gray-500">Up to 100 products</span>
                            </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="ml-3 text-gray-500">Advanced inventory</span>
                            </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="ml-3 text-gray-500">Custom domain support</span>
                            </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="ml-3 text-gray-500">Priority support</span>
                        </li>
                    </ul>
                    </div>
                    
                    <a href="{{ route('register') }}" class="mt-8 block w-full bg-blue-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-blue-700">
                        Get started
                    </a>
                </div>
                
                <!-- Business Plan -->
                <div class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900">Business</h3>
                        <p class="mt-4 flex items-baseline text-gray-900">
                            <span class="text-5xl font-extrabold tracking-tight">$79</span>
                            <span class="ml-1 text-xl font-semibold">/month</span>
                        </p>
                        <p class="mt-6 text-gray-500">For growing businesses with complex needs.</p>
                        
                        <ul role="list" class="mt-6 space-y-6">
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="ml-3 text-gray-500">Unlimited products</span>
                            </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="ml-3 text-gray-500">Advanced analytics</span>
                            </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                                <span class="ml-3 text-gray-500">Multiple team members</span>
                            </li>
                            <li class="flex">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                                <span class="ml-3 text-gray-500">24/7 phone support</span>
                            </li>
                        </ul>
                    </div>
                    
                    <a href="{{ route('register') }}" class="mt-8 block w-full bg-blue-50 border border-blue-100 rounded-md py-2 text-sm font-semibold text-blue-600 text-center hover:bg-blue-100">
                        Get started
                    </a>
                </div>
            </div>
        </div>
        </div>

    <!-- CTA Section -->
    <div class="bg-blue-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to dive in?</span>
                <span class="block text-blue-200">Start your free trial today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                        Get started
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500">
                        Learn more
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
