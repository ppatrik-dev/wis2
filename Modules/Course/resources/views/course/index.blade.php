<x-course::layouts.master>
    <x-header headline="Courses">
        <x-slot:actions>
            <x-button href="{{ route('course.create') }}" rounded="rounded-lg">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14m-7 7V5" />
                </svg>
                Create Course
            </x-button>
        </x-slot:actions>
    </x-header>

    <div class="mb-4">
        <form method="get" action="{{ route('course.index') }}">
            <div
                class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-3.5">
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="q" value="{{ isset($query) ? e($query) : '' }}"
                            placeholder="Search courses by name or code..."
                            class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <button type="submit"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Search</button>

                    @if(!empty($query))
                        <a href="{{ route('course.index') }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">Clear</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <x-course::table :courses="$courses" />

</x-course::layouts.master>