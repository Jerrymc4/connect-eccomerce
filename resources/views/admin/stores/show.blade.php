@extends('admin.layouts.app')

@section('header', $store->name)

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $store->name }}</h1>
        <p class="text-sm text-gray-500">ID: {{ $store->id }}</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.stores.edit', $store) }}" class="admin-button">
            Edit Store
        </a>
        
        <form action="{{ route('admin.stores.destroy', $store) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this store? This action cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="admin-danger-button">
                Delete Store
            </button>
        </form>
    </div>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Store Details</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Basic information about the store.</p>
        </div>
        <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ 
            $store->status === 'active' ? 'bg-green-100 text-green-800' : 
            ($store->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') 
        }}">
            {{ ucfirst($store->status) }}
        </span>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Store URL</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if($store->domains->isNotEmpty())
                        <a href="https://{{ $store->domains->first()->domain }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                            https://{{ $store->domains->first()->domain }}
                            <svg class="inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    @else
                        <span class="text-gray-500">No domain configured</span>
                    @endif
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Description</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $store->description ?? 'No description provided' }}</dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Created On</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $store->created_at->format('F j, Y \a\t g:i a') }}</dd>
            </div>
        </dl>
    </div>
</div>

<div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Owner Information</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Details about the store owner.</p>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Owner Name</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $store->owner_name ?? 'Not specified' }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Owner Email</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <a href="mailto:{{ $store->owner_email }}" class="text-indigo-600 hover:text-indigo-900">
                        {{ $store->owner_email }}
                    </a>
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Owner Account</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if(isset($store->owner))
                        <a href="#" class="text-indigo-600 hover:text-indigo-900">
                            {{ $store->owner->name }} ({{ $store->owner->email }})
                        </a>
                    @else
                        <span class="text-gray-500">No platform account linked</span>
                    @endif
                </dd>
            </div>
        </dl>
    </div>
</div>

<div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Business Details</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Business information for the store.</p>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Business Name</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $store->business_name ?? 'Not specified' }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Business Email</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if($store->email)
                        <a href="mailto:{{ $store->email }}" class="text-indigo-600 hover:text-indigo-900">
                            {{ $store->email }}
                        </a>
                    @else
                        <span class="text-gray-500">Not specified</span>
                    @endif
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $store->phone ?? 'Not specified' }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Tax ID</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $store->tax_id ?? 'Not specified' }}</dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Address</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if($store->address_line1)
                        {{ $store->address_line1 }}<br>
                        @if($store->address_line2) {{ $store->address_line2 }}<br> @endif
                        @if($store->city || $store->state || $store->postal_code)
                            {{ $store->city ?? '' }} {{ $store->state ?? '' }} {{ $store->postal_code ?? '' }}<br>
                        @endif
                        {{ $store->country ?? '' }}
                    @else
                        <span class="text-gray-500">Not specified</span>
                    @endif
                </dd>
            </div>
        </dl>
    </div>
</div>

<div class="mt-8 flex justify-between">
    <a href="{{ route('admin.stores.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
        </svg>
        Back to Stores
    </a>

    <div class="flex space-x-3">
        @if($store->status !== 'active')
            <form action="#" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="active">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Activate
                </button>
            </form>
        @endif

        @if($store->status !== 'inactive')
            <form action="#" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="inactive">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Deactivate
                </button>
            </form>
        @endif
    </div>
</div>
@endsection 