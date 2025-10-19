@props([
    'width' => '10',
    'height' => '10',
    'text' => 'sm',
    'letters' => null,
    'photo' => null
])

<div class="relative inline-flex items-center justify-center w-{{ $width }} h-{{ $height }} overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
    @if ($letters)
        <span class="font-medium text-{{ $text }} text-gray-600 dark:text-gray-300">{{ $letters }}</span>
    @elseif ($photo)
        <img class="w-{{ $width }} h-{{ $height }}" src="{{ $photo }}" alt="User Avatar">
    @else
        <div class="relative w-{{ $width }} h-{{ $height }} bg-gray-100 rounded-full dark:bg-gray-600">
            <svg class="absolute w-{{ $width + 2}} h-{{ $height + 2}} text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
        </div>
    @endif
</div>