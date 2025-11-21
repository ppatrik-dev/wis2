@props([
    'width' => '10',
    'height' => '10',
    'text' => 'sm',
    'letters' => null,
])

<div
    class="relative inline-flex items-center justify-center overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600"
    style="width: {{ $width }}px; height: {{ $height }}px;"
>
    @if ($letters)
        <span class="font-medium text-{{ $text }} text-gray-600 dark:text-gray-300">{{ $letters }}</span>
    @else
        <div class="relative bg-gray-100 rounded-full dark:bg-gray-600" style="width: {{ $width}}px; height: {{ $height}}px;">
            <svg class="text-gray-600 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
            </svg>

        </div>
    @endif
</div>
