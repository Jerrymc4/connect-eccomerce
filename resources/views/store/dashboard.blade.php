@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">{{ $store->name }} Dashboard</h1>
        <div class="flex space-x-4">
            <a href="{{ route('store.settings', ['store' => $store->slug]) }}" class="btn-secondary inline-flex items-center">
                <x-icons.cog class="mr-2" /> Settings
            </a>
            <a href="{{ route('store.products.create', ['store' => $store->slug]) }}" class="btn-primary inline-flex items-center">
                <x-icons.plus class="mr-2" /> Add Product
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Today's Sales</h3>
            <p class="text-3xl font-bold">$0.00</p>
            <p class="text-sm text-gray-600">0 orders</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Products</h3>
            <p class="text-3xl font-bold">0</p>
            <p class="text-sm text-gray-600">Active products</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Customers</h3>
            <p class="text-3xl font-bold">0</p>
            <p class="text-sm text-gray-600">Total customers</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Low Stock</h3>
            <p class="text-3xl font-bold">0</p>
            <p class="text-sm text-gray-600">Products to restock</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold">Recent Orders</h2>
            </div>
            <div class="p-6">
                <div class="text-center text-gray-500 py-4">
                    No orders yet
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('store.products.index', ['store' => $store->slug]) }}" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                        <x-icons.box class="h-8 w-8 mx-auto mb-2" />
                        <p>Manage Products</p>
                    </a>
                    <a href="{{ route('store.orders.index', ['store' => $store->slug]) }}" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                        <x-icons.shopping-cart class="h-8 w-8 mx-auto mb-2" />
                        <p>View Orders</p>
                    </a>
                    <a href="{{ route('store.customers.index', ['store' => $store->slug]) }}" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                        <x-icons.users class="h-8 w-8 mx-auto mb-2" />
                        <p>Customers</p>
                    </a>
                    <a href="{{ route('store.reports', ['store' => $store->slug]) }}" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                        <x-icons.chart-bar class="h-8 w-8 mx-auto mb-2" />
                        <p>Reports</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 