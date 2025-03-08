@extends('admin.layouts.app')

@section('header', 'Create Store')

@section('content')
<form action="{{ route('admin.stores.store') }}" method="POST" class="space-y-8">
    @csrf
    
    <div class="bg-white shadow sm:rounded-md">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Store Information</h3>
            <div class="mt-5 grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Store Name *</label>
                    <input type="text" name="name" id="name" class="admin-input mt-1" value="{{ old('name') }}" required>
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="domain" class="block text-sm font-medium text-gray-700">Domain Name *</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">https://</span>
                        <input type="text" name="domain" id="domain" class="admin-input rounded-none rounded-r-md" placeholder="mystore.example.com" value="{{ old('domain') }}" required>
                    </div>
                    @error('domain')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="owner_id" class="block text-sm font-medium text-gray-700">Store Owner</label>
                    <select name="owner_id" id="owner_id" class="admin-input mt-1">
                        <option value="">Select Owner</option>
                        @foreach($owners ?? [] as $owner)
                            <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                {{ $owner->name }} ({{ $owner->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('owner_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                    <select name="status" id="status" class="admin-input mt-1" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                    @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="owner_email" class="block text-sm font-medium text-gray-700">Owner Email *</label>
                    <input type="email" name="owner_email" id="owner_email" class="admin-input mt-1" value="{{ old('owner_email') }}" required>
                    @error('owner_email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="owner_name" class="block text-sm font-medium text-gray-700">Owner Name</label>
                    <input type="text" name="owner_name" id="owner_name" class="admin-input mt-1" value="{{ old('owner_name') }}">
                    @error('owner_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="admin-input mt-1">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow sm:rounded-md">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Business Details</h3>
            <div class="mt-5 grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                    <input type="text" name="business_name" id="business_name" class="admin-input mt-1" value="{{ old('business_name') }}">
                    @error('business_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="tax_id" class="block text-sm font-medium text-gray-700">Tax ID</label>
                    <input type="text" name="tax_id" id="tax_id" class="admin-input mt-1" value="{{ old('tax_id') }}">
                    @error('tax_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" class="admin-input mt-1" value="{{ old('phone') }}">
                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Business Email</label>
                    <input type="email" name="email" id="email" class="admin-input mt-1" value="{{ old('email') }}">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="logo_url" class="block text-sm font-medium text-gray-700">Logo URL</label>
                    <input type="url" name="logo_url" id="logo_url" class="admin-input mt-1" value="{{ old('logo_url') }}">
                    @error('logo_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow sm:rounded-md">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Address</h3>
            <div class="mt-5 grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="address_line1" class="block text-sm font-medium text-gray-700">Address Line 1</label>
                    <input type="text" name="address_line1" id="address_line1" class="admin-input mt-1" value="{{ old('address_line1') }}">
                    @error('address_line1')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label for="address_line2" class="block text-sm font-medium text-gray-700">Address Line 2</label>
                    <input type="text" name="address_line2" id="address_line2" class="admin-input mt-1" value="{{ old('address_line2') }}">
                    @error('address_line2')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="city" id="city" class="admin-input mt-1" value="{{ old('city') }}">
                    @error('city')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700">State/Province</label>
                    <input type="text" name="state" id="state" class="admin-input mt-1" value="{{ old('state') }}">
                    @error('state')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                    <input type="text" name="postal_code" id="postal_code" class="admin-input mt-1" value="{{ old('postal_code') }}">
                    @error('postal_code')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                    <input type="text" name="country" id="country" class="admin-input mt-1" value="{{ old('country') }}">
                    @error('country')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end">
        <a href="{{ route('admin.stores.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Cancel
        </a>
        <button type="submit" class="admin-button ml-3">
            Create Store
        </button>
    </div>
</form>
@endsection 