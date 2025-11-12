@props([
    'term' => null,
])

@if ($errors->any())
    <div class="errors">
        @foreach ($errors->all() as $index => $error)
            <x-alert type="error" message="{{ $error }}" color="red" id="{{ $index }}"></x-alert>
        @endforeach
    </div>
@endif

<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $term?->name ? ucfirst($term->name) : '' }}</h2>
        </div>

        {{ $slot }}
    </div>
</div>