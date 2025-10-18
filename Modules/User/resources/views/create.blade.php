<x-user::layouts.master>

    <x-header headline="Users">
        <x-slot:actions>
            <x-button variant="primary" href="{{ route('user.store') }}" rounded="rounded-s-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8"/>
                </svg>

                Save
            </x-button>

            <x-button variant="danger" href="{{ route('user.create') }}">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h13a5 5 0 0 1 0 10H7M3 9l4-4M3 9l4 4"/>
                </svg>
                Clear
            </x-button>

            <x-button variant="default" href="{{ route('user.index') }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                Close
            </x-button>
        </x-slot:actions>

    </x-header>
    <x-user::profile :roles="$roles"></x-user::profile>

</x-user::layouts.master>

        {{-- <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
        </svg> --}}