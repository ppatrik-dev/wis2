@props([
    'href' => null,
    'variant' => 'default',
    'type' => 'button'
])

@php
$variants = [
    'default' => 'text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 
                font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white 
                dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700',

    'primary' => 'text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 
                dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none',
                
    'danger'  => 'focus:outline-none text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg
                text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700',
];
$classes = ($variants[$variant] ?? $variants['default']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
