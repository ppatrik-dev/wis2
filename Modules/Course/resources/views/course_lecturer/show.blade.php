<x-course::layouts.master>
    <x-header headline="Lecturer Details">
        <x-slot:actions>
            @auth
               @can('course-lecturer.delete',$course)
                    <x-button form="lecturerDeleteForm" type="submit" variant="danger">
                        <svg class="w-3 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                clip-rule="evenodd" />
                        </svg>
                        Remove
                    </x-button>
                    @endcan
            @endauth
            <x-button href="{{ route('course.lecturer.index', $courseId) }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
                Close
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-course::profile :courseLecturer="$courseLecturer">
        <form id="lecturerDeleteForm" action="{{ route('course.lecturer.destroy', [$courseId, $lecturerId]) }}"
            method="POST" class="grid w-full max-w-lg grid-cols-1 gap-6 py-10 mx-auto"
            onsubmit="return confirm('Are you sure you want to remove this lecturer from the course?');">
            @csrf
            @method('DELETE')
            <x-input label="Lecturer Name" name="lecturer_name"
                value="{{ $courseLecturer->lecturer->first_name . ' ' . $courseLecturer->lecturer->last_name }}"
                :disabled="true"></x-input>
            <x-input label="Course Name" name="course_name" value="{{ $courseLecturer->course->name }}"
                :disabled="true"></x-input>
            <x-input label="Role" name="role" value="{{ $courseLecturer->role }}" :disabled="true"></x-input>
            <x-input label="Assigned At" name="created_at"
                value="{{ $courseLecturer->created_at ? $courseLecturer->created_at->format('Y-m-d H:i') : 'N/A' }}"
                :disabled="true"></x-input>
        </form>
    </x-course::profile>
</x-course::layouts.master>
