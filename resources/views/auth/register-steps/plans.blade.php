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
                                            <x-icons.check class="w-5 h-5 text-primary-500 mt-0.5 mr-3 flex-shrink-0" />
                                            <span class="text-gray-600">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <x-icons.box-archive class="text-gray-400 mr-2" />
                                    <span>{{ $plan->max_products }} products</span>
                                </div>
                                <div class="flex items-center">
                                    <x-icons.users-group class="text-gray-400 mr-2" />
                                    <span>{{ $plan->max_staff_accounts }} staff accounts</span>
                                </div>
                                <div class="flex items-center">
                                    <x-icons.globe-alt class="text-gray-400 mr-2" />
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