@props([
    'href' => null,
    'variant' => 'default',
    'type' => 'button',
    'rounded' => ''
])

@php
$baseClasses = 'inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 border border-gray-200 hover:bg-gray-100 
                dark:bg-gray-800 dark:border-gray-700 
                dark:text-white dark:hover:bg-gray-700';
$variants = [
    "primary" => 'hover:text-blue-700 dark:hover:text-blue-500',
    "default" => 'dark:hover:text-white',
    'danger' => 'hover:text-red-700 dark:hover:text-red-500'
];

$classes =  $baseClasses . ' ' . ($variants[$variant] ?? '') . ' ' . $rounded;
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
