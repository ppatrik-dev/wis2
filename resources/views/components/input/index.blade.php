@props([
    'input' => 'input',
    'type' => 'text',
    'name' => '',
    'value' => '',
    'required' => false,
    'disabled' => false
])

@php
    $classes = 'block w-full resize-none overflow-y-auto p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-sm
                focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
@endphp

@if ($input == "input")
    <div>
        <label class="block mb-1 text-sm font-medium text-gray-500">{{ $name }} {!! $required ? '<span class="text-blue-500">*</span>' : '' !!}</label>
        <input type={{ $type }} value="{{ $value }}" {{ $attributes->merge(['class' => $classes]) }} @disabled($disabled)></input>
    </div>
@elseif ($input == "textarea")
    <div class="row-span-2">
        <label class="block mb-1 text-sm font-medium text-gray-500">{{ $name }} </label>
        <textarea rows="5" value="{{ $value }}" {{ $attributes->merge(['class' => $classes]) }} @disabled($disabled)></textarea>
    </div>
@endif