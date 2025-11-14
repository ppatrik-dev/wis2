@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'selected' => '',
    'required' => false,
    'disabled' => false
])

<div {{ $attributes->merge([]) }}>
    <label for="select-{{ $name }}" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-500">{{ $label }} {!! $required ? '<span class="text-blue-500">*</span>' : '' !!}</label>
    <select id="select-{{ $name }}" name="{{ $name }}" class="group relative w-full h-9.5 p-2 flex items-center dark:text-white border border-gray-300 rounded-lg
                bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" @required($required) @disabled($disabled)>
        @if($required)
            <option value="" hidden></option>
        @else
            <option value="">Not Selected</option>
        @endif
        @foreach ($options as $key => $option)
            @php
                $isSequential = ($key === $loop->index);
                $value = $isSequential ? $option : $key;
                $label = $option;
            @endphp
            <option value="{{ $value }}" {{ (string) old($name, $selected ?? '') === (string) $value ? 'selected' : '' }}>
                {{ $label instanceof \Illuminate\Support\Htmlable ? $label : ucfirst($label) }}
            </option>
        @endforeach
    </select>
</div>
