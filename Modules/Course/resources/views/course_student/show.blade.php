<x-course::layouts.master>
    <x-header headline="Student Enrollment Details">
        <x-slot:actions>
            @auth
                @if(!auth()->user()->hasRole('student'))
                    @can('course-student.update',$course)
                    <x-button href="{{ route('course.student.edit', [$courseId, $studentId]) }}" rounded="rounded-s-lg" variant="primary">
                        <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                        </svg>
                        Edit
                    </x-button>
                    @endcan
                    @can('course-student.delete',$course)
                    <x-button form="studentDeleteForm" type="submit" variant="danger">
                        <svg class="w-3 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                        </svg>
                        Remove
                    </x-button>
                    @endcan
                @endif
            @endauth
            <x-button href="{{ route('course.student.index', $courseId) }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                Close
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-course::profile :courseStudent="$courseStudent">
        <form id="studentDeleteForm" action="{{ route('course.student.destroy', [$courseId, $studentId]) }}" method="POST" class="grid w-full grid-cols-3 gap-6 py-10 mx-auto max-w-3/4"
                onsubmit="return confirm('Are you sure you want to remove this student from the course?');">
            @csrf
            @method('DELETE')
            <x-input label="Student Name" name="student_name" value="{{ $courseStudent->student->first_name . ' ' . $courseStudent->student->last_name }}" :disabled="true"></x-input>
            <x-input label="Course Name" name="course_name" value="{{ $courseStudent->course->name }}" :disabled="true"></x-input>
            <x-input label="Final Score" name="final_score" value="{{ $courseStudent->final_score ?? 'Not assigned' }}" :disabled="true"></x-input>
            <x-input label="Status" name="is_approved" value="{{ $courseStudent->is_approved ? 'Approved' : 'Pending' }}" :disabled="true"></x-input>
            <x-input label="Enrolled At" name="created_at" value="{{ $courseStudent->created_at->format('Y-m-d H:i') }}" :disabled="true"></x-input>
            <x-input label="Approved At" name="approved_at" value="{{ $courseStudent->approved_at ? $courseStudent->approved_at->format('Y-m-d H:i') : 'Not approved' }}" :disabled="true"></x-input>
        </form>
    </x-course::profile>
</x-course::layouts.master>
