@props([
    'term' => null,
])

<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        @isset($term)
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $term->name ? ucfirst($term->name) : '' }}</h2>
            <p class="text-gray-600 dark:text-gray-300">{{ ucfirst($term->course?->name) }}</p>
        </div>
        @endisset

        {{ $slot }}
    </div>
</div>