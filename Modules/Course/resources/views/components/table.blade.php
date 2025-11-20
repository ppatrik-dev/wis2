<div class="relative overflow-x-auto overflow-y-visible min-h-[300px]">
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @if(isset($courses))
                    <th scope="col" class="px-6 py-3">Code</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Academic Year</th>
                    <th scope="col" class="px-6 py-3">Credits</th>
                    <th scope="col" class="px-6 py-3">Type</th>
                    <th scope="col" class="px-6 py-3">Registration</th>
                    <th scope="col" class="px-6 py-3">Register</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                @elseif(isset($courseStudents))
                    <th scope="col" class="px-6 py-3">Student</th>
                    <th scope="col" class="px-6 py-3">Final Score</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Enrolled At</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                @elseif(isset($courseLecturers))
                    <th scope="col" class="px-6 py-3">Lecturer</th>
                    <th scope="col" class="px-6 py-3">Role</th>
                    <th scope="col" class="px-6 py-3">Assigned At</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                @elseif(isset($courseNews))
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Author</th>
                    <th scope="col" class="px-6 py-3">Created At</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                @elseif (isset($myCourses))
                    <th scope="col" class="px-6 py-3">Code</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Academic Year</th>
                    <th scope="col" class="px-6 py-3">Credits</th>
                     <th scope="col" class="px-6 py-3">Type</th>
                    <th scope="col" class="px-6 py-3">Points</th>
                    <th scope="col" class="px-6 py-3">Grade</th>
                    <th scope="col" class="px-6 py-3">Completed</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if(isset($courses))
                @auth
                    <form method="POST" action="{{ route('course.student.update-registrations') }}" id="courses-action-form">
                        @csrf
                        <input type="hidden" name="_method" value="POST">
                @endauth
                    @foreach($courses as $course)
                        <tr
                            class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">

                            <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"> <a
                                    href="{{ route('course.show', $course->id) }}">{{ $course->code }}</a></td>

                            <td class="px-6 py-3"><a href="{{ route('course.show', $course->id) }}">{{ $course->name }}</a></td>

                            <td class="px-6 py-3">{{ $course->academic_year }}</td>
                            <td class="px-6 py-3">{{ $course->credits }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full {{ $course->type === 'mandatory' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($course->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @auth
                                    @php
                                        $isEnrolled = isset($course->students) && $course->students->contains('id', auth()->id());
                                        $myPivot = $isEnrolled ? $course->students->firstWhere('id', auth()->id())->pivot : null;
                                    @endphp
                                    <div class="mt-2 text-xs">
                                        @if($isEnrolled)
                                            @if($myPivot && $myPivot->is_approved)
                                                <span class="text-green-700">Registered (approved)</span>
                                            @else
                                                <span class="text-yellow-700">Registered (pending approval)</span>
                                            @endif
                                        @else
                                            <span class="text-gray-600">Not registered</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-600">Not registered</span>
                                @endauth
                            </td>
                            <td class="px-6 py-3">
                                @auth
                                    {{-- Send list of visible courses and selected ones. Absence of a course in selected_course_ids
                                    means user wants it unregistered. --}}
                                    @cannot('course.register',$course)
                                    <input type="hidden" name="visible_course_ids[]" value="{{ $course->id }}">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="selected_course_ids[]" value="{{ $course->id }}"
                                            class="w-4 h-4 mr-2 text-blue-600 border-gray-300 rounded course-checkbox"
                                            data-initial="{{ $isEnrolled ? '1' : '0' }}" {{ $isEnrolled ? 'checked' : '' }}>
                                        <span class="text-sm">{{ $isEnrolled ? 'Registered' : 'Register' }}</span>
                                    </label>
                                       @endcannot
                                @else
                                    <a href="{{ route('login') }}"
                                        class="px-2 py-1 text-xs font-medium text-white bg-blue-600 rounded">Login to register</a>
                                @endauth
                            </td>
                            <td class="inline-flex px-6 py-3">
                                @auth
                                    {{-- Admin actions: only show if user can update course (policy check) --}}
                                    @can('course.update', $course)
                                        <a href="{{ route('course.edit', $course->id) }}"
                                            class="font-medium text-blue-600 {{ $isEnrolled ? 'ms-3' : '' }} dark:text-blue-500 hover:underline" title="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    @endcan
                                    {{-- Students/Lecturers management: only for admin/guarantor --}}
                                    @php
                                        $canViewStudents = auth()->user()->hasRole('admin')
                                            || (auth()->user()->hasRole('guarantor') && $course->guarantor_id === auth()->id())
                                            || (auth()->user()->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', auth()->id())->exists());
                                        $canViewLecturers = auth()->user()->hasRole('admin')
                                            || (auth()->user()->hasRole('guarantor') && $course->guarantor_id === auth()->id());
                                    @endphp
                                    @if($canViewStudents)
                                        <a href="{{ route('course.student.index', $course->id) }}"
                                            class="font-medium text-blue-600 ms-3 dark:text-blue-500 hover:underline" title="Students">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm-9 9a9 9 0 0 1 18 0v1H3Z" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if($canViewLecturers)
                                        <a href="{{ route('course.lecturer.index', $course->id) }}"
                                            class="font-medium text-blue-600 ms-3 dark:text-blue-500 hover:underline" title="Lecturers">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M7 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm10-2h2a2 2 0 0 1 2 2v10h-2V12h-2v10h-2V12a2 2 0 0 1 2-2Z" />
                                            </svg>
                                        </a>
                                    @endif
                                    @php
                                        $user = auth()->user();
                                        $isEnrolled = isset($course->students) && $course->students->contains('id', $user->id);
                                        $isGuarantor = $user->hasRole('guarantor') && $course->guarantor_id === $user->id;
                                        $isLecturer = $user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists();
                                        $canViewNews = $isEnrolled || $isGuarantor || $isLecturer || $user->hasRole('admin');
                                    @endphp
                                    {{-- News icon: show if enrolled, is guarantor, is lecturer, or is admin --}}
                                    @if($canViewNews)
                                        <a href="{{ route('course.news.index', $course->id) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="View News">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M4 5h16v2H4V5Zm0 4h16v2H4V9Zm0 4h16v2H4v-2Zm0 4h10v2H4v-2Z" />
                                            </svg>
                                        </a>
                                    @endif
                                @endauth
                            </td>
                        </tr>
                    @endforeach
                    @auth
                        <div class="flex justify-end p-4">
                            <button id="update-registrations-btn" type="submit"
                                formaction="{{ route('course.student.update-registrations') }}"
                                class="px-4 py-2 text-sm font-medium text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-indigo-600"
                                disabled>Update registrations</button>
                        </div>
                        </form>
                    @endauth
            @elseif(isset($courseStudents))
                @foreach($courseStudents as $student)
                    <tr
                        class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('course.student.show', [$courseId, $student->id]) }}">
                                {{ $student->first_name }} {{ $student->last_name }}
                            </a>

                        </td>
                        <td class="px-6 py-3">{{ $student->pivot->final_score ?? 'Not assigned' }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 text-xs font-medium rounded-full {{ $student->pivot->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $student->pivot->is_approved ? 'Approved' : 'Pending' }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            {{ $student->pivot->created_at ? $student->pivot->created_at->format('d-m-Y') : 'N/A' }}
                        </td>
                        <td class="inline-flex px-6 py-3">
                            @auth
                                @if(!auth()->user()->hasRole('student') && auth()->user()->hasAnyRole(['admin', 'guarantor', 'lecturer']))
                                    <a href="{{ route('course.student.edit', [$courseId, $student->id]) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Edit">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    @if(!$student->pivot->is_approved && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('guarantor')))
                                        <form method="POST" action="{{ route('course.student.approve', [$courseId, $student->id]) }}"
                                            class="inline ms-3">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="p-0 font-medium text-green-600 bg-transparent cursor-pointer dark:text-green-500 hover:underline"
                                                title="Approve">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endauth
                        </td>
                    </tr>
                @endforeach
            @elseif(isset($courseLecturers))
                @foreach($courseLecturers as $lecturer)
                    <tr
                        class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('course.lecturer.show', [$courseId, $lecturer->id]) }}">
                                {{ $lecturer->first_name }} {{ $lecturer->last_name }}
                            </a>

                        </td>
                        <td class="px-6 py-3"> <a
                                href="{{ route('course.lecturer.show', [$courseId, $lecturer->id]) }}">{{ $lecturer->pivot->role }}
                            </a></td>
                        <td class="px-6 py-3">
                            {{ $lecturer->pivot->created_at ? $lecturer->pivot->created_at->format('d-m-Y') : 'N/A' }}
                        </td>
                        <td class="inline-flex px-6 py-3">
                            @auth
                                @php
                                    $course = \Modules\Course\Models\Course::find($courseId);
                                    $user = auth()->user();
                                @endphp
                                @if(!$user->hasRole('student') && ($user->hasRole('admin') || ($course && $course->guarantor_id === $user->id)))
                                    <form method="POST" action="{{ route('course.lecturer.destroy', [$courseId, $lecturer->id]) }}"
                                        onsubmit="return confirm('Are you sure you want to remove this lecturer from the course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Remove</button>
                                    </form>
                                @endif
                            @endauth
                        </td>
                    </tr>
                @endforeach
            @elseif(isset($courseNews))
                @foreach($courseNews as $news)
                    <tr
                        class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"> <a
                                href="{{ route('course.news.show', [$courseId, $news->id]) }}">

                                {{ $news->title }}</a></td>
                        <td class="px-6 py-3"><a
                                href="{{ route('course.news.show', [$courseId, $news->id]) }}">{{ $news->author->first_name }}
                                {{ $news->author->last_name }}</a></td>
                        <td class="px-6 py-3">{{ $news->created_at->format('Y-m-d H:i') }}</td>
                        <td class="inline-flex px-6 py-3">
                            @can('course-news.update', $news)
                                <a href="{{ route('course.news.edit', [$courseId, $news->id]) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Edit">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endcan
                            @can('course-news.delete', $news)
                                <form method="POST" action="{{ route('course.news.destroy', [$courseId, $news->id]) }}"
                                    class="inline ms-3"
                                    onsubmit="return confirm('Are you sure you want to delete this news?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-0 font-medium text-red-600 bg-transparent cursor-pointer dark:text-red-500 hover:underline" title="Delete">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach

             @elseif(isset($myCourses))
                    @foreach($myCourses as $course)
                        @php
                         $score = $course->pivot->final_score ?? 0;
                            // $score = $course->terms
                            //     ->where('student_id', auth()->id())
                            //     ->sum('pivot.score');
                                switch(true) {
                                case $score >= 90:
                                    $grade = 'A';
                                    break;
                                case $score >= 80:
                                    $grade = 'B';
                                    break;
                                case $score >= 70:
                                    $grade = 'C';
                                    break;
                                case $score >= 60:
                                    $grade = 'D';
                                    break;
                                case $score >= 50:
                                    $grade = 'E';
                                    break;
                                default:
                                    $grade = 'F';
                            }
                        @endphp
                        <tr
                            class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">

                            <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"> <a
                                    href="{{ route('course.show', $course->id) }}">{{ $course->code }}</a></td>

                            <td class="px-6 py-3"><a href="{{ route('course.show', $course->id) }}">{{ $course->name }}</a></td>

                            <td class="px-6 py-3">{{ $course->academic_year }}</td>
                            <td class="px-6 py-3">{{ $course->credits }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full {{ $course->type === 'mandatory' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($course->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">{{$score}}</td>
                            <td class="px-6 py-3 font-bold text-lg {{ $score < 50 ? 'text-red-800' : 'text-green-800' }}"">{{$grade}}</td>
                            <td class="px-6 py-3">
                                @if($score >= 50)
                                <svg class="w-6 h-6 text-gray-800 dark:text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
                                </svg>
                                @else
                                <svg class="w-6 h-6 text-gray-800 dark:text-red-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                                </svg>

                                @endif
                            </td>
                            @php

                            @endphp
                        </tr>
                    @endforeach
                      @endif
        </tbody>
    </table>
</div>
@auth
    <script>
        console.log('Registration button script loading...');

        function initRegistrationButton() {
            console.log('Initializing registration button...');

            const form = document.getElementById('courses-action-form');
            const btn = document.getElementById('update-registrations-btn');

            console.log('Form found:', !!form);
            console.log('Button found:', !!btn);

            if (!form) {
                console.warn('Form not found, retrying...');
                setTimeout(initRegistrationButton, 200);
                return;
            }

            if (!btn) {
                console.warn('Button not found, retrying...');
                setTimeout(initRegistrationButton, 200);
                return;
            }

            // Find checkboxes - try both inside form and globally
            let checkboxes = form.querySelectorAll('.course-checkbox');
            if (checkboxes.length === 0) {
                checkboxes = document.querySelectorAll('.course-checkbox');
            }

            console.log('Checkboxes found:', checkboxes.length);

            if (checkboxes.length === 0) {
                console.warn('No checkboxes found, retrying...');
                setTimeout(initRegistrationButton, 200);
                return;
            }

            // Store initial states
            const initialStates = Array.from(checkboxes).map(cb => cb.checked);
            console.log('Initial checkbox states:', initialStates);

            function updateButtonState() {
                const currentStates = Array.from(checkboxes).map(cb => cb.checked);
                const hasChanged = currentStates.some((checked, i) => checked !== initialStates[i]);

                console.log('Current states:', currentStates);
                console.log('Has changed:', hasChanged);

                if (hasChanged) {
                    btn.disabled = false;
                    btn.removeAttribute('disabled');
                    btn.style.opacity = '1';
                    btn.style.cursor = 'pointer';
                    btn.style.pointerEvents = 'auto';
                    console.log('Button ENABLED');
                } else {
                    btn.disabled = true;
                    btn.setAttribute('disabled', 'disabled');
                    btn.style.opacity = '0.5';
                    btn.style.cursor = 'not-allowed';
                    btn.style.pointerEvents = 'none';
                    console.log('Button DISABLED');
                }
            }

            // Add click listener to verify button works
            btn.addEventListener('click', function(e) {
                console.log('Button clicked!', e);
                if (btn.disabled) {
                    console.warn('Button is disabled, preventing submission');
                    e.preventDefault();
                    return false;
                }
            });

            // Use event delegation - listen on document to catch all changes
            document.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('course-checkbox')) {
                    console.log('Checkbox changed:', e.target.checked, e.target.value);
                    updateButtonState();
                }
            });

            // Also listen directly on form
            form.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('course-checkbox')) {
                    console.log('Checkbox changed in form:', e.target.checked);
                    updateButtonState();
                }
            });

            // Initial state
            updateButtonState();
            console.log('Registration button initialized successfully');
        }

        // Try multiple initialization methods
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOMContentLoaded fired');
                initRegistrationButton();
            });
        } else {
            console.log('DOM already ready');
            initRegistrationButton();
        }

        // Also try after a delay as fallback
        setTimeout(function() {
            const btn = document.getElementById('update-registrations-btn');
            if (btn && btn.disabled) {
                console.log('Fallback: Re-initializing after delay');
                initRegistrationButton();
            }
        }, 1000);
    </script>
@endauth
