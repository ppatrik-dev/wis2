<x-course::layouts.master>
    <x-header headline="Edit Student Enrollment">
        <x-slot:actions>
            <x-button type="submit" form="studentForm" rounded="rounded-s-lg" variant="primary">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8"/>
                </svg>
                Save
            </x-button>
            <x-button href="{{ route('course.student.show', [$courseId, $studentId]) }}" variant="danger">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>
                </svg>
                Discard
            </x-button>
            <x-button href="{{ route('course.student.index', $courseId) }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                Close
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-course::profile :courseStudent="$courseStudent">
        <form id="studentForm" action="{{ route('course.student.update', [$courseId, $studentId]) }}" method="POST" class="grid w-full grid-cols-1 gap-6 py-10 mx-auto max-w-3/4">
            @csrf
            @method('PUT')
            <x-input label="Student Name" name="student_name" value="{{ $courseStudent->student->first_name . ' ' . $courseStudent->student->last_name }}" :disabled="true"></x-input>
            <x-input label="Course Name" name="course_name" value="{{ $courseStudent->course->name }}" :disabled="true"></x-input>
            <x-input label="Final Score" name="final_score" type="number" min="0" max="100" value="{{ $courseStudent->final_score }}"></x-input>
            <x-toggle label="Is Approved" name="is_approved" :checked="$courseStudent->is_approved"/>
        </form>
    </x-course::profile>
</x-course::layouts.master>
