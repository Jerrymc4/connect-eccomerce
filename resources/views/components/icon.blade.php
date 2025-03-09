@props(['name', 'class' => ''])

<i data-feather="{{ $name }}" {{ $attributes->merge(['class' => $class]) }}></i> 