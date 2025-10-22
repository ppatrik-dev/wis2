@props([
    'label' => '',
    'name' => '',
    'default' => '',
    'value' => '',
    'options' => [],
    'selected' => collect(),
    'disabled' => false
])

<div>
    <label class="block mb-1 text-sm font-medium text-gray-500">{{ $label }}</label>
    <button id="dropdownMenuButton" data-dropdown-toggle="dropdownMenu"  
        class="group relative w-full h-9.5 p-2 flex items-center dark:text-white border border-gray-300 rounded-lg
                bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 focus:ring-1"
        type="button", @disabled($disabled)>
        
        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-2.5 h-2.5 text-gray-500 dark:text-gray-400 
                    group-disabled:pointer-events-none" 
            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>

        {{ $selected->isNotEmpty() ? $selected->map(fn($s) => ucfirst($s))->join(', ') : ucfirst($default) }}
    </button>
</div>

<div id="dropdownMenu" class="z-10 hidden bg-white rounded-lg shadow-sm w-72 dark:bg-gray-700">
    <ul class="overflow-y-auto text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuhButton">
        @foreach($options as $option)
            <li>
                <div class="flex items-center p-1.5 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                @php
                    $checked = collect(old($name, $selected->toArray()));
                @endphp

                @if($option->name === $default)
                    <input type="hidden" name="{{ $name }}[]" value="{{ $default }}">
                @endif

                <input id="checkbox-item-{{ $option->name }}" type="checkbox" name="{{ $name }}[]" value="{{ $option->name }}" 
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600
                         dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                        @checked($checked->contains($option->name)) @disabled($option->name === $default)>
                <label for="checkbox-item-{{ $option->name }}" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">
                    {{ ucfirst($option->name) }}
                </label>
                </div>
            </li>
        @endforeach
    </ul>
</div>