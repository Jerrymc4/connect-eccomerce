@extends('admin.layouts.app')

@section('header', 'Stores')

@section('content')
<div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Stores</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all stores in your platform including their name, status, and owner.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="{{ route('admin.stores.create') }}" class="admin-button">
            Add Store
        </a>
    </div>
</div>

<!-- Store Filters -->
<div class="mt-6">
    <form method="GET" action="{{ route('admin.stores.index') }}" class="space-y-4 lg:flex lg:items-end lg:space-y-0 lg:space-x-3">
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
            <div class="mt-1">
                <input type="text" name="search" id="search" class="admin-input" placeholder="Store name, email, domain..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <div class="mt-1">
                <select id="status" name="status" class="admin-input">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
        </div>
        
        <div>
            <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
            <div class="mt-1">
                <select id="sort" name="sort" class="admin-input">
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Status</option>
                </select>
            </div>
        </div>
        
        <div>
            <label for="direction" class="block text-sm font-medium text-gray-700">Direction</label>
            <div class="mt-1">
                <select id="direction" name="direction" class="admin-input">
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </div>
        </div>
        
        <div>
            <button type="submit" class="admin-button">
                Filter
            </button>
        </div>
        
        <div>
            <a href="{{ route('admin.stores.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Stores Table -->
<div class="mt-8 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Store</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Owner</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($stores ?? [] as $store)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            @if($store->logo_url)
                                                <img class="h-10 w-10 rounded-full" src="{{ $store->logo_url }}" alt="{{ $store->name }} logo">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                                    {{ substr($store->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $store->name }}</div>
                                            <div class="text-gray-500">{{ $store->domains->first()->domain ?? 'No domain' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="text-gray-900">{{ $store->owner_name ?? 'Unknown' }}</div>
                                    <div class="text-gray-500">{{ $store->owner_email }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ 
                                        $store->status === 'active' ? 'bg-green-100 text-green-800' : 
                                        ($store->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') 
                                    }}">
                                        {{ ucfirst($store->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $store->created_at->format('M d, Y') }}
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <a href="{{ route('admin.stores.show', $store) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    <span class="text-gray-300 mx-2">|</span>
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No stores found. <a href="{{ route('admin.stores.create') }}" class="text-indigo-600 hover:text-indigo-900">Create your first store</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
@if(isset($stores) && $stores->hasPages())
    <div class="mt-6">
        {{ $stores->links() }}
    </div>
@endif
@endsection 