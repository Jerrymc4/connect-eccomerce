@extends('auth.layouts.app')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Choose Your Plan</h1>
        <p class="text-gray-600 mt-1">Select the right plan for your business</p>
    </div>

    <div class="flex justify-center mb-4">
        <div class="inline-flex rounded-md shadow-sm">
            <span class="relative z-0 inline-flex">
                <div class="flex items-center bg-blue-600 rounded-md py-1 px-4 text-white">
                    <span class="flex h-6 w-6 rounded-full bg-white text-blue-600 justify-center items-center mr-2">1</span>
                    <span>Choose Plan</span>
                </div>
                <div class="flex items-center bg-gray-100 rounded-md py-1 px-4 text-gray-400 ml-1">
                    <span class="flex h-6 w-6 rounded-full bg-gray-300 text-gray-600 justify-center items-center mr-2">2</span>
                    <span>Account</span>
                </div>
                <div class="flex items-center bg-gray-100 rounded-md py-1 px-4 text-gray-400 ml-1">
                    <span class="flex h-6 w-6 rounded-full bg-gray-300 text-gray-600 justify-center items-center mr-2">3</span>
                    <span>Store</span>
                </div>
            </span>
        </div>
    </div>

    <form method="POST" action="{{ route('register.select-plan') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            @foreach($plans as $plan)
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow 
                            {{ $plan->is_featured ? 'border-blue-300 bg-blue-50' : 'border-gray-200' }}">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $plan->name }}</h3>
                            <div class="text-2xl font-bold text-gray-800">
                                {{ $plan->formattedPrice() }}
                                <span class="text-sm font-normal text-gray-500">/{{ $plan->billing_period }}</span>
                            </div>
                        </div>
                        @if($plan->is_featured)
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Popular</span>
                        @endif
                    </div>
                    
                    <p class="text-gray-600 text-sm mb-4">{{ $plan->description }}</p>
                    
                    <ul class="space-y-2 mb-4">
                        @foreach(json_decode($plan->features) as $feature)
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div class="mt-4">
                        <ul class="space-y-1 text-sm text-gray-500 mb-4">
                            <li>{{ $plan->max_products }} products</li>
                            <li>{{ $plan->max_staff_accounts }} staff accounts</li>
                            <li>{{ $plan->has_custom_domain ? 'Custom domain' : 'No custom domain' }}</li>
                        </ul>
                        
                        <button type="submit" name="plan_id" value="{{ $plan->id }}" 
                                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white 
                                       {{ $plan->is_featured ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-600 hover:bg-gray-700' }} 
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Select {{ $plan->name }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm text-gray-500">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Log in</a>
        </p>
    </div>
@endsection 