<x-course::layouts.master>
    <x-header headline="Create News">
        <x-slot:actions>
            <x-button type="submit" form="newsForm" rounded="rounded-s-lg" variant="primary">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8"/>
                </svg>
                Create
            </x-button>

            <x-button href="{{ route('course.news.create', $courseId) }}" variant="danger">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h13a5 5 0 0 1 0 10H7M3 9l4-4M3 9l4 4"/>
                </svg>
                Clear
            </x-button>

            <x-button href="{{ route('course.news.index', $courseId) }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                Close
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-course::profile>
        <form id="newsForm" action="{{ route('course.news.store', $courseId) }}" method="POST" class="grid w-full max-w-lg grid-cols-1 gap-6 py-10 mx-auto">
            @csrf
            <x-input label="Title" name="title" :required="true" placeholder="News title..."></x-input>
            <x-input label="Description" name="description" input="textarea" :required="true" placeholder="News description..."></x-input>
        </form>
    </x-course::profile>
</x-course::layouts.master>
