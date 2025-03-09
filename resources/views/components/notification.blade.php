@props([
    'type' => 'info',
    'dismissible' => true,
    'show' => true
])

@php
    $typeClasses = [
        'success' => 'bg-green-50 border-green-500 text-green-700',
        'error' => 'bg-red-50 border-red-500 text-red-700',
        'warning' => 'bg-yellow-50 border-yellow-500 text-yellow-700',
        'info' => 'bg-blue-50 border-blue-500 text-blue-700',
    ][$type] ?? 'bg-blue-50 border-blue-500 text-blue-700';
    
    $iconClasses = [
        'success' => 'text-green-400',
        'error' => 'text-red-400',
        'warning' => 'text-yellow-400',
        'info' => 'text-blue-400',
    ][$type] ?? 'text-blue-400';

    $iconName = [
        'success' => 'check-circle',
        'error' => 'x-circle',
        'warning' => 'alert-triangle',
        'info' => 'info',
    ][$type] ?? 'info';
@endphp

<div 
    x-data="{ show: {{ $show ? 'true' : 'false' }} }"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="alert {{ $typeClasses }} {{ $attributes->get('class') }}"
    role="alert"
>
    <div class="flex">
        <div class="flex-shrink-0">
            <x-icon :name="$iconName" class="{{ $iconClasses }}" />
        </div>
        <div class="ml-3 flex-1">
            <div class="text-sm">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="show = false" type="button" class="inline-flex bg-{{substr($type, 0, 1)}}-50 rounded-md p-1.5 {{substr($type, 0, 1)}}-500 hover:bg-{{substr($type, 0, 1)}}-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{substr($type, 0, 1)}}-500">
                        <span class="sr-only">Dismiss</span>
                        <x-icon name="x" class="h-5 w-5" />
                    </button>
                </div>
            </div>
        @endif
    </div>
</div> 