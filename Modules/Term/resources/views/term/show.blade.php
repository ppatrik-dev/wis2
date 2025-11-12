<x-term::layouts.master>
    <x-header headline="Term Details">
        <x-slot:actions>
            <x-button href="{{ route('term.edit', $term->id) }}" rounded="rounded-s-lg" variant="primary">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                </svg>
                Edit
            </x-button>
            <x-button form="termDeleteForm" type="submit" variant="danger">
                <svg class="w-3 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                </svg>
                Delete
            </x-button>
            <x-button href="{{ route('term.index') }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                Close
            </x-button>
        </x-slot:actions>
    </x-header>
    <x-term::profile :term="$term">
        <form id="termDeleteForm" action="{{ route('term.destroy', $term->id) }}" method="POST" class="grid w-full grid-cols-3 gap-6 py-10 mx-auto max-w-3/4"
                onsubmit="return confirm('Are you sure you want to delete this course?');">
            @csrf
            @method('DELETE')
            <x-input label="Name" name="name" value="{{ ucfirst($term->name) }}" :disabled="true"></x-input>
            <x-input label="Type" name="type" value="{{ ucfirst($term->type) }}" :disabled="true"></x-input>
            <x-input label="Registration" name="registration_required" :value="$term->registration_required ? 'Required' : 'Not Required'" :disabled="true"></x-input>
            <x-input label="Datetime" name="event_datetime" :value="$term->event_datetime?->format('Y-m-d H:i')" type="datetime-local" :disabled="true"></x-input>
            <x-input label="Capacity" name="capacity" value="{{ $term->capacity }}" type="number" :disabled="true"></x-input>
            <x-input label="Max score" name="max_score" value="{{ $term->max_score }}" type="number" :disabled="true"></x-input>
            <x-input label="Course" name="course" value="{{ $term->course?->name }}" placeholder="Not selected" :disabled="true"></x-input>
            <x-input label="Lecturer" name="lecturer" value="{{ $term->lecturer?->getFullNameAttribute() }}" placeholder="Not selected" :disabled="true"></x-input>
            <x-input label="Room" name="room" value="{{ $term->room?->name }}" placeholder="Not selected" :disabled="true"></x-input>
            <x-input label="Description" name="description" value="{{ $term->description }}" input="textarea" :disabled="true" rows="3" class="col-span-3"></x-input>
        </form>
    </x-term::profile>
</x-term::layouts.master>