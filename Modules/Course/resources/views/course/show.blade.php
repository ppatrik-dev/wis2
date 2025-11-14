<x-course::layouts.master>
    <x-header headline="Course Details">
        <x-slot:actions>
            @can('update', $course)
                <x-button href="{{ route('course.edit', $course->id) }}" rounded="rounded-s-lg" variant="primary">
                    <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                    </svg>
                    Edit
                </x-button>
            @endcan
            @can('delete', $course)
                <x-button form="courseDeleteForm" type="submit" variant="danger">
                    <svg class="w-3 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                    </svg>
                    Delete
                </x-button>
            @endcan
            <x-button href="{{ route('course.index') }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                Close
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-course::profile :course="$course">
        <form id="courseDeleteForm" action="{{ route('course.destroy', $course->id) }}" method="POST" class="grid w-full grid-cols-3 gap-6 py-10 mx-auto max-w-3/4"
                onsubmit="return confirm('Are you sure you want to delete this course?');">
            @csrf
            @method('DELETE')
            <x-input label="Credits" name="credits" value="{{ $course->credits }}" :disabled="true"></x-input>
            <x-input label="Capacity" name="capacity" value="{{ $course->capacity }}" :disabled="true"></x-input>
            <x-input label="Type" name="type" value="{{ ucfirst($course->type) }}" :disabled="true"></x-input>
            <x-input label="Guarantor" name="guarantor" value="{{ $course->guarantor ? $course->guarantor->first_name . ' ' . $course->guarantor->last_name : 'Not assigned' }}" :disabled="true"></x-input>
            <x-input label="Auto Enroll" name="auto_enroll_confirm" value="{{ $course->auto_enroll_confirm ? 'Yes' : 'No' }}" :disabled="true"></x-input>
            <x-input label="Status" name="is_approved" value="{{ $course->is_approved ? 'Approved' : 'Pending' }}" :disabled="true"></x-input>
            <x-input label="Description" name="description" value="{{ $course->description }}" input="textarea" :disabled="true" class="col-span-3"></x-input>
        </form>
    </x-course::profile>
</x-course::layouts.master>
