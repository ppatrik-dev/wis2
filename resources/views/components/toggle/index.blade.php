@props([
    'name',
    'label' => '',
    'checked' => false,
])

<label class="flex flex-col items-start mb-5 cursor-pointer">
    <span class="block mb-1 text-sm font-medium text-gray-500">
        {{ $label }}
    </span>
    <input type="checkbox" name="{{ $name }}" value="1" class="sr-only peer"
           @if($checked) checked @endif>
    <div
        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700
               peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
               peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px]
               after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all
               peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
    </div>
</label>
