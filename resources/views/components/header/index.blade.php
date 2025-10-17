<header class="flex items-center justify-between px-3 pb-6">
    <h2 class="text-4xl font-semibold dark:text-white">
        {{ $headline }}
    </h2>

    @isset($actions)
        <div class="flex items-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</header>
