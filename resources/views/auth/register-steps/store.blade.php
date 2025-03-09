@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
    <div class="w-full sm:max-w-3xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Set Up Your Store</h2>
            <p class="mt-2 text-sm text-gray-600">Enter your store details to complete registration.</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                        <x-icons.check-circle />
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-900">Plan</span>
                </div>
                <div class="flex-grow border-t-2 border-primary-100"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                        <x-icons.check-circle />
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-900">Account</span>
                </div>
                <div class="flex-grow border-t-2 border-primary-100"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center">
                        <span class="text-sm font-medium">3</span>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-900">Store</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
            @csrf

            <!-- Store Information -->
            <div class="bg-gray-50 px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Store Information</h3>
                        <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly on your store.</p>
                    </div>
                    <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Store Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', session('store_form_data.name')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" required>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Store Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('description', session('store_form_data.description')) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Business Details -->
            <div class="bg-gray-50 px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Business Details</h3>
                        <p class="mt-1 text-sm text-gray-500">Provide your business information for legal and tax purposes.</p>
                    </div>
                    <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="business_name" class="block text-sm font-medium text-gray-700">Legal Business Name</label>
                                <input type="text" name="business_name" id="business_name" value="{{ old('business_name', session('store_form_data.business_name')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="tax_id" class="block text-sm font-medium text-gray-700">Tax ID</label>
                                <input type="text" name="tax_id" id="tax_id" value="{{ old('tax_id', session('store_form_data.tax_id')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', session('store_form_data.phone')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Business Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', session('store_form_data.email')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="bg-gray-50 px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Business Address</h3>
                        <p class="mt-1 text-sm text-gray-500">Your business's physical location.</p>
                    </div>
                    <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label for="address_line1" class="block text-sm font-medium text-gray-700">Street Address</label>
                                <input type="text" name="address_line1" id="address_line1" value="{{ old('address_line1', session('store_form_data.address_line1')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>

                            <div class="col-span-6">
                                <label for="address_line2" class="block text-sm font-medium text-gray-700">Apartment, suite, etc.</label>
                                <input type="text" name="address_line2" id="address_line2" value="{{ old('address_line2', session('store_form_data.address_line2')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" id="city" value="{{ old('city', session('store_form_data.city')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="state" class="block text-sm font-medium text-gray-700">State / Province</label>
                                <input type="text" name="state" id="state" value="{{ old('state', session('store_form_data.state')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">ZIP / Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', session('store_form_data.postal_code')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <select id="country" name="country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    <option value="US" {{ old('country', session('store_form_data.country')) == 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('country', session('store_form_data.country')) == 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="MX" {{ old('country', session('store_form_data.country')) == 'MX' ? 'selected' : '' }}>Mexico</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="bg-gray-50 px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Store Branding</h3>
                        <p class="mt-1 text-sm text-gray-500">Upload your store logo.</p>
                    </div>
                    <div class="mt-5 md:col-span-2 md:mt-0">
                        <div class="flex items-center">
                            <span class="h-12 w-12 overflow-hidden rounded-full bg-gray-100">
                                <x-icons.user-circle class="text-gray-300" />
                            </span>
                            <input type="file" name="logo" id="logo" accept="image/*" class="ml-5 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('register.account') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500">Back to Account Setup</a>
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-gradient-to-r from-primary-600 to-primary-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:from-primary-700 hover:to-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                    Create Store
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 