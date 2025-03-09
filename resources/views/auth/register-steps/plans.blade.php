@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Choose Your Plan</h1>
        <p class="text-gray-600 mt-2 text-lg">Select the perfect plan for your business needs</p>
    </div>

    <!-- Progress Steps -->
    <div class="flex justify-center mb-8">
        <div class="flex items-center w-full max-w-3xl">
            <div class="flex-1 relative">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary-600 rounded-full">
                        <span class="text-white font-semibold">1</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-primary-600">Choose Plan</p>
                        <p class="text-xs text-gray-500">Select your subscription</p>
                    </div>
                </div>
                <div class="w-full h-1 bg-primary-600 absolute top-5 left-0 -z-10"></div>
            </div>
            
            <div class="flex-1 relative">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-200 rounded-full">
                        <span class="text-gray-600 font-semibold">2</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600">Account</p>
                        <p class="text-xs text-gray-500">Create your account</p>
                    </div>
                </div>
                <div class="w-full h-1 bg-gray-200 absolute top-5 left-0 -z-10"></div>
            </div>
            
            <div class="flex-1">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-200 rounded-full">
                        <span class="text-gray-600 font-semibold">3</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600">Store</p>
                        <p class="text-xs text-gray-500">Setup your store</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('register.select-plan') }}" class="max-w-6xl mx-auto">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($plans as $plan)
                <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 
                    {{ $plan->is_featured ? 'ring-2 ring-primary-500 ring-offset-2' : 'border border-gray-100' }}">
                    @if($plan->is_featured)
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="bg-gradient-to-r from-primary-600 to-primary-500 text-white text-sm font-medium px-4 py-1 rounded-full shadow-sm">
                                Most Popular
                            </span>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900">{{ $plan->name }}</h3>
                            <div class="mt-2">
                                <span class="text-4xl font-bold text-gray-900">{{ $plan->formattedPrice() }}</span>
                                <span class="text-gray-500">/{{ $plan->billing_period }}</span>
                            </div>
                            <p class="mt-3 text-gray-600">{{ $plan->description }}</p>
                        </div>

                        <div class="space-y-4">
                            <div class="border-t border-b border-gray-100 py-4">
                                <ul class="space-y-3">
                                    @foreach(json_decode($plan->features) as $feature)
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-primary-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-gray-600">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                        <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $plan->max_products }} products</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                    </svg>
                                    <span>{{ $plan->max_staff_accounts }} staff accounts</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $plan->has_custom_domain ? 'Custom domain support' : 'No custom domain' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" name="plan_id" value="{{ $plan->id }}" 
                                class="w-full py-3 px-4 rounded-xl text-sm font-semibold transition-all duration-200
                                    {{ $plan->is_featured 
                                        ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white hover:from-primary-700 hover:to-primary-600 shadow-lg hover:shadow-xl hover:-translate-y-0.5' 
                                        : 'bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                                Get Started with {{ $plan->name }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </form>

    <div class="mt-8 text-center">
        <p class="text-gray-600">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-700">
                Sign in to your account
            </a>
        </p>
    </div>
@endsection 