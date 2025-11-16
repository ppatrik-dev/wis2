<x-term::layouts.master>
    <x-header headline="Rooms">
        <x-slot:actions>
            @can('room.create')
            <x-button href="{{ route('room.create') }}" rounded="rounded-lg">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                </svg>
                Create
            </x-button>
            @endcan
        </x-slot:actions>
    </x-header>

    <x-term::table :rooms="$rooms" />

</x-term::layouts.master>
