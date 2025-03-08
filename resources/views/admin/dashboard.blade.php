@extends('admin.layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Total Stores Card -->
    <div class="admin-card">
        <div class="flex items-start">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-medium text-gray-900">Total Stores</h2>
                <p class="mt-1 text-3xl font-semibold text-gray-700">{{ $totalStores ?? 0 }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.stores.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all stores &rarr;</a>
        </div>
    </div>

    <!-- Total Users Card -->
    <div class="admin-card">
        <div class="flex items-start">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-medium text-gray-900">Total Users</h2>
                <p class="mt-1 text-3xl font-semibold text-gray-700">{{ $totalUsers ?? 0 }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all users &rarr;</a>
        </div>
    </div>

    <!-- Recent Activity Card -->
    <div class="admin-card">
        <div class="flex items-start">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-medium text-gray-900">Recent Activity</h2>
                <p class="mt-1 text-sm text-gray-500">Last updated: {{ now()->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Stores -->
<div class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Recent Stores</h2>
        <a href="{{ route('admin.stores.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
    </div>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">
            @forelse($recentStores ?? [] as $store)
            <li>
                <a href="{{ route('admin.stores.show', $store) }}" class="block hover:bg-gray-50">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-indigo-600 truncate">{{ $store->name }}</p>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $store->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($store->status) }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    {{ $store->owner_email }}
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <p>Created <time datetime="{{ $store->created_at->format('Y-m-d') }}">{{ $store->created_at->format('M d, Y') }}</time></p>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            @empty
            <li class="px-4 py-4 sm:px-6 text-gray-500 text-center">No stores found</li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('admin.stores.create') }}" class="admin-card flex items-center hover:bg-gray-50 transition-colors">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">Create Store</h3>
                <p class="mt-1 text-sm text-gray-500">Add a new store to the platform</p>
            </div>
        </a>
        
        <a href="{{ route('admin.users.create') }}" class="admin-card flex items-center hover:bg-gray-50 transition-colors">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">Add User</h3>
                <p class="mt-1 text-sm text-gray-500">Create a new user account</p>
            </div>
        </a>
        
        <a href="{{ route('admin.settings.index') }}" class="admin-card flex items-center hover:bg-gray-50 transition-colors">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">Platform Settings</h3>
                <p class="mt-1 text-sm text-gray-500">Configure application settings</p>
            </div>
        </a>
    </div>
</div>
@endsection 