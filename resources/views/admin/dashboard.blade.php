<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Connect E-commerce') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-xl font-semibold text-indigo-600">{{ config('app.name', 'Connect') }}</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-700">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="ml-4">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h2 class="text-2xl font-bold mb-4">Welcome to your store dashboard!</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Store Info -->
                        <div class="bg-gray-50 p-6 rounded-lg shadow">
                            <h3 class="font-bold text-lg mb-2">Your Stores</h3>
                            @php
                                $stores = Auth::user()->ownedStores;
                            @endphp

                            @if($stores->count() > 0)
                                <ul class="space-y-2">
                                    @foreach($stores as $store)
                                        <li class="p-3 bg-white rounded shadow-sm">
                                            <div class="font-medium">{{ $store->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                @if($store->domains->count() > 0)
                                                    <a href="https://{{ $store->domains->first()->domain }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                                        {{ $store->domains->first()->domain }}
                                                    </a>
                                                @else
                                                    No domain set
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500">You don't have any stores yet.</p>
                                <a href="#" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800">Create a store</a>
                            @endif
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-gray-50 p-6 rounded-lg shadow">
                            <h3 class="font-bold text-lg mb-2">Quick Actions</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="#" class="block p-3 bg-white rounded shadow-sm hover:bg-gray-50">
                                        <span class="font-medium">Create a new store</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="block p-3 bg-white rounded shadow-sm hover:bg-gray-50">
                                        <span class="font-medium">View all stores</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="block p-3 bg-white rounded shadow-sm hover:bg-gray-50">
                                        <span class="font-medium">Account settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Help & Resources -->
                        <div class="bg-gray-50 p-6 rounded-lg shadow">
                            <h3 class="font-bold text-lg mb-2">Help & Resources</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="#" class="block p-3 bg-white rounded shadow-sm hover:bg-gray-50">
                                        <span class="font-medium">Documentation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="block p-3 bg-white rounded shadow-sm hover:bg-gray-50">
                                        <span class="font-medium">Support</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="block p-3 bg-white rounded shadow-sm hover:bg-gray-50">
                                        <span class="font-medium">FAQs</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 