<x-term::layouts.master>
    <x-header headline="Rooms">
        <x-slot:actions>
            @can('room.create')
            <x-button href="{{ route('room.create') }}" rounded="rounded-lg">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                </svg>
                Create Room
            </x-button>
            @endcan
        </x-slot:actions>
    </x-header>

    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between my-2">
        <form method="GET" action="{{ route('room.index') }}"
                class="w-full flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-3">
            <div class="flex items-center gap-2">
                <label for="room-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>

                    <input type="text" id="room-search" name="query" value="{{ isset($query) ? e($query) : '' }}"
                        placeholder="Search room by name"
                        class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 ps-10 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" />
                </div>

                <button type="submit"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none dark:bg-blue-500 dark:hover:bg-blue-600  hover:cursor-pointer">
                    Search
                </button>

                @if(!empty($query))
                    <button name="query" value="" type="submit" onclick="{{ route('room.index') }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600 hover:cursor-pointer">
                        Clear
                    </button>
                @endif
            </div>
        </div>

    <x-term::table :rooms="$rooms" />

</x-term::layouts.master>
