@props([
    'name' => '',
    'options' => [],
    'selected' => null,
    'width' => 30
])

<div>
    <input hidden name="{{ $name }}" value="{{ $selected }}"></input>
            
    <div class="flex-col gap-y-1">
        <button id="dropdown{{ ucfirst($name) }}Button" data-dropdown-toggle="dropdown{{ ucfirst($name) }}" 
                class="inline-flex justify-between items-center w-{{ $width }} text-gray-500 bg-white border border-gray-300 hover:bg-gray-100font-medium rounded-lg text-sm px-3 py-1.5
                dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                type="button">
            <span class="sr-only">{{ ucfirst($name) }} button</span>
            @if (!empty($selected))
                <span class="text-black dark:text-white">{{ ucfirst($selected) }}</span>
            @else
                {{ ucfirst($name) }}
            @endif

            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>

        <div id="dropdown{{ ucfirst($name) }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-md shadow-sm w-{{ $width }} dark:bg-gray-700 dark:divide-gray-600">
            <ul class="text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown{{ $name }}Button">
                <li>
                    <button type="submit" name="{{ $name }}" value=""
                            class="w-full text-left px-5 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:cursor-pointer">
                        All {{ ucfirst($name) }}s
                    </button>
                </li>

                @foreach ($options as $option)
                <li>
                    <button type="submit" name="{{ $name }}" value="{{ $option }}"
                            class="w-full text-left px-5 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:cursor-pointer">
                        {{ ucfirst($option) }}
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>