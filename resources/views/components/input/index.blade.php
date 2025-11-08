@props([
    'input' => 'input',
    'type' => 'text',
    'name' => '',
    'label' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
])

@php
    $classes = 'block w-full resize-none overflow-y-auto p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-sm
                focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
@endphp

@if ($input == "input")
    <div {{ $attributes->merge([]) }}>
        <label for="input-{{ $name }}" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
            {{ $label }} {!! $required ? '<span class="text-blue-500">*</span>' : '' !!}
        </label>
        <input id="input-{{ $name }}" type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" class="{{ $classes }}" @required($required) @disabled($disabled)>
    </div>
@elseif ($input == "textarea")
    <div {{ $attributes->merge([]) }}>
        <label for="textarea-{{ $name }}" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
        <textarea id="textarea-{{ $name }}" rows="5" name="{{ $name }}" class="{{ $classes }}" @disabled($disabled)>{{ old($name, $value) }}</textarea>
    </div>
@endif
