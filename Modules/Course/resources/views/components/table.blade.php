<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $course->code }}</td>
                    <td class="px-6 py-4">{{ $course->name }}</td>
                    <td class="px-6 py-4">{{ $course->academic_year }}</td>
                    <td class="px-6 py-4">{{ $course->credits }}</td>
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
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('course.show', $course->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ route('course.edit', $course->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            <a href="{{ route('course.student.index', $course->id) }}" class="text-green-600 hover:text-green-900">Students</a>
                            <a href="{{ route('course.lecturer.index', $course->id) }}" class="text-purple-600 hover:text-purple-900">Lecturers</a>
                            <a href="{{ route('course.news.index', $course->id) }}" class="text-indigo-600 hover:text-indigo-900">News</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            @elseif(isset($courseStudents))
                @foreach($courseStudents as $student)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $student->first_name }} {{ $student->last_name }}
                    </td>
                    <td class="px-6 py-4">{{ $student->pivot->final_score ?? 'Not assigned' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $student->pivot->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $student->pivot->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $student->pivot->created_at ? $student->pivot->created_at->format('d-m-Y') : 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('course.student.show', [$courseId, $student->id]) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ route('course.student.edit', [$courseId, $student->id]) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            @if(!$student->pivot->is_approved)
                                <a href="{{ route('course.student.approve', [$courseId, $student->id]) }}" class="text-green-600 hover:text-green-900">Approve</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @elseif(isset($courseLecturers))
                @foreach($courseLecturers as $lecturer)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $lecturer->first_name }} {{ $lecturer->last_name }}
                    </td>
                    <td class="px-6 py-4">{{ $lecturer->pivot->role }}</td>
                    <td class="px-6 py-4">{{ $lecturer->pivot->created_at ? $lecturer->pivot->created_at->format('d-m-Y') : 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('course.lecturer.show', [$courseId, $lecturer->id]) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ route('course.lecturer.edit', [$courseId, $lecturer->id]) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            @elseif(isset($courseNews))
                @foreach($courseNews as $news)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $news->title }}</td>
                    <td class="px-6 py-4">{{ $news->author->first_name }} {{ $news->author->last_name }}</td>
                    <td class="px-6 py-4">{{ $news->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('course.news.show', [$courseId, $news->id]) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ route('course.news.edit', [$courseId, $news->id]) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
