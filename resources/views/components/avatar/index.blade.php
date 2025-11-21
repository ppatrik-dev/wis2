@props([
    'width' => '10',
    'height' => '10',
    'text' => 'sm',
    'top' => '3',
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
            <svg class="absolute text-gray-400 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="width: {{ $width  }}px; height: {{ $height}}px;">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                </path>
            </svg>
        </div>
    @endif
</div>
