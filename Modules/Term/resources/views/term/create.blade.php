<x-term::layouts.master>
    <x-header headline="Create Term">
        <x-slot:actions>
            <x-button type="submit" form="termCreateForm" rounded="rounded-s-lg" variant="primary">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8"/>
                </svg>
                Save
            </x-button>

            <x-button href="{{ route('term.create') }}" variant="danger">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h13a5 5 0 0 1 0 10H7M3 9l4-4M3 9l4 4"/>
                </svg>
                Clear
            </x-button>

            <x-button href="{{ route('term.index') }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                Close
            </x-button>
        </x-slot:actions>
    </x-header>
    <x-term::profile>
        <form id="termCreateForm" action="{{ route('term.store') }}" method="POST" class="grid w-full grid-cols-3 gap-6 py-10 mx-auto max-w-3/4">
            @csrf
            <x-input label="Name" name="name" :required="true"></x-input>
            <x-select label="Type" name="type" :options="['lecture','exercise','exam','assignment']" :required="true"></x-select>
            <x-toggle label="Registration required" name="registration_required" :required="true"></x-toggle>
            <x-input label="Start at" name="start_at" type="datetime-local" :required="true"></x-input>
             <x-input label="End at" name="end_at" type="datetime-local" :required="true"></x-input>
            <x-input label="Capacity" name="capacity" type="number" :required="true"></x-input>
            <x-input label="Max score" name="max_score" type="number" :required="true"></x-input>
            <x-select label="Lecturer" name="lecturer" :options="$users"></x-select>
            <x-select label="Room" name="room" :options="$rooms"></x-select>
            <x-select label="Course" name="course" :options="$courses" :required="true"></x-select>
            <x-input label="Description" name="description" input="textarea" rows="3" class="col-span-3"></x-input>
        </form>
   </x-term::profile>
</x-term::layouts.master>
