@props([
    'headline' => '',
])
<header class="flex items-center justify-between px-3 pb-6">
    <h2 class="text-4xl font-semibold dark:text-white">
        {{ $headline }}
    </h2>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" id="1" />
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $index => $error)
            <x-alert type="error" message="{{ $error }}" color="red" id="{{ $index }}"></x-alert>
        @endforeach
    @endif

    @isset($actions)
        <div class="inline-flex rounded-md shadow-xs">
            {{ $actions }}
        </div>
    @endisset
</header>
