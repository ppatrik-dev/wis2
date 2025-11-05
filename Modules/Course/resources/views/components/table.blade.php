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
                    <th scope="col" class="px-6 py-3">Status</th>
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
                @endif
            </tr>
        </thead>
        <tbody>
            @if(isset($courses))
                @foreach($courses as $course)
                <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $course->code }}</td>
                    <td class="px-6 py-3">{{ $course->name }}</td>
                    <td class="px-6 py-3">{{ $course->academic_year }}</td>
                    <td class="px-6 py-3">{{ $course->credits }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $course->type === 'mandatory' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($course->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $course->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $course->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </td>
                    <td class="inline-flex px-6 py-3">
                        <a href="{{ route('course.show', $course->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="View">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Z"/>
                            </svg>
                        </a>
                        <a href="{{ route('course.edit', $course->id) }}" class="ms-3 font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Edit">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="{{ route('course.student.index', $course->id) }}" class="ms-3 font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Students">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm-9 9a9 9 0 0 1 18 0v1H3Z"/>
                            </svg>
                        </a>
                        <a href="{{ route('course.lecturer.index', $course->id) }}" class="ms-3 font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Lecturers">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm10-2h2a2 2 0 0 1 2 2v10h-2V12h-2v10h-2V12a2 2 0 0 1 2-2Z"/>
                            </svg>
                        </a>
                        <a href="{{ route('course.news.index', $course->id) }}" class="ms-3 font-medium text-blue-600 dark:text-blue-500 hover:underline" title="News">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 5h16v2H4V5Zm0 4h10v2H4V9Zm0 4h16v2H4v-2Zm0 4h10v2H4v-2Z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            @elseif(isset($courseStudents))
                @foreach($courseStudents as $student)
                <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $student->first_name }} {{ $student->last_name }}
                    </td>
                    <td class="px-6 py-3">{{ $student->pivot->final_score ?? 'Not assigned' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $student->pivot->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $student->pivot->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </td>
                    <td class="px-6 py-3">{{ $student->pivot->created_at ? $student->pivot->created_at->format('d-m-Y') : 'N/A' }}</td>
                    <td class="inline-flex px-6 py-3">
                        <a href="{{ route('course.student.show', [$courseId, $student->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="View">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Z"/>
                            </svg>
                        </a>
                        <a href="{{ route('course.student.edit', [$courseId, $student->id]) }}" class="ms-3 font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Edit">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        @if(!$student->pivot->is_approved)
                            <form method="POST" action="{{ route('course.student.approve', [$courseId, $student->id]) }}" class="inline ms-3">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="p-0 font-medium text-green-600 bg-transparent cursor-pointer dark:text-green-500 hover:underline" title="Approve">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41Z"/>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            @elseif(isset($courseLecturers))
                @foreach($courseLecturers as $lecturer)
                <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $lecturer->first_name }} {{ $lecturer->last_name }}
                    </td>
                    <td class="px-6 py-3">{{ $lecturer->pivot->role }}</td>
                    <td class="px-6 py-3">{{ $lecturer->pivot->created_at ? $lecturer->pivot->created_at->format('d-m-Y') : 'N/A' }}</td>
                    <td class="inline-flex px-6 py-3">
                        <a href="{{ route('course.lecturer.show', [$courseId, $lecturer->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="View">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Z"/>
                            </svg>
                        </a>
                        <a href="{{ route('course.lecturer.edit', [$courseId, $lecturer->id]) }}" class="ms-3 font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Edit">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            @elseif(isset($courseNews))
                @foreach($courseNews as $news)
                <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $news->title }}</td>
                    <td class="px-6 py-3">{{ $news->author->first_name }} {{ $news->author->last_name }}</td>
                    <td class="px-6 py-3">{{ $news->created_at->format('Y-m-d H:i') }}</td>
                    <td class="inline-flex px-6 py-3">
                        <a href="{{ route('course.news.show', [$courseId, $news->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="View">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Z"/>
                            </svg>
                        </a>
                        <a href="{{ route('course.news.edit', [$courseId, $news->id]) }}" class="ms-3 font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Edit">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
