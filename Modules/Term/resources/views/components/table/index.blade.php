<div class="relative overflow-x-auto overflow-y-visible min-h-[300px]">
    @isset($terms)
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Course
                </th>
                <th scope="col" class="px-6 py-3">
                    Type
                </th>
                <th scope="col" class="px-6 py-3">
                    Your score
                </th>
                <th scope="col" class="px-6 py-3">
                    Max score
                </th>
                <th scope="col" class="px-6 py-3">
                    Capacity
                </th>
                {{-- <th scope="col" class="px-6 py-3">
                    Start at
                </th>
                   <th scope="col" class="px-6 py-3">
                    End at
                </th> --}}
                <th scope="col" class="px-6 py-3">
                    Registration
                </th>
                <th scope="col" class="py-3 pl-1">
                   Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($terms as $term)
            @can('term.view', $term)
                @php
                    $pivot = $term->termStudents()->where('student_id', Auth::id())->first();
                @endphp

                <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3 text-base font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="{{ route('term.show', $term->id) }}">
                            {{ $term->name }}
                        </a>
                    </td>
                    <td class="px-6 py-3">
                        {{ $term->course?->code }}
                    </td>
                    <td class="px-6 py-3">
                        {{ ucfirst($term->type) }}
                    </td>
                    <td class="px-6 py-3">
                        {{ $pivot->score ?? '-' }}
                    </td>
                    <td class="px-6 py-3">
                        {{ $term->max_score }}
                    </td>
                    <td class="px-6 py-3">
                        {{ $term->capacity }}
                    </td>
                    {{-- <td class="px-6 py-3">
                        {{ $term->start_at->format('d M Y H:i') }}
                    </td>
                        <td class="px-6 py-3">
                        {{ $term->end_at->format('d M Y H:i') }}
                    </td> --}}
                    <td class="px-6 py-3">
                        @if($term->registration_required)
                            <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                Required
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                Not Required
                            </span>
                        @endif
                    </td>
                    <td class="inline-flex gap-3 py-3 pl-1">
                        @can('register', $term)
                        @if ($pivot)
                            @if(isset($pivot->score))
                                <span>Evaluated</span>
                            @else
                                <form action="{{ route('term.student.unregister', $term) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="w-20 text-left text-red-600 underline bg-transparent border-none hover:cursor-pointer">
                                        Unregister
                                    </button>
                                </form>
                            @endif
                        @else
                            <form action="{{ route('term.student.register', $term) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="w-20 text-left text-blue-600 underline bg-transparent border-none hover:cursor-pointer">
                                    Register
                                </button>
                            </form>
                        @endif
                        @endcan
                        @can('term.update', $term)
                        <a href="{{ route('term.edit', $term->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Edit">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        @endcan
                        {{-- <form action="{{ route('term.student.register', $term) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Register" class="font-medium hover:cursor-pointer">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        </form> --}}
                        @can('term-student.viewAny', $term)
                        <a href="{{ route('term.student.index', $term) }}" title="Students">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        @endcan
                        @can('term.delete', $term)
                        <form action="{{ route('term.destroy', $term->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this term?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-0 font-medium text-red-600 bg-transparent cursor-pointer dark:text-red-500 hover:underline" title="Delete">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endcan
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
    {{ $terms->links() }}
    </div>
    @endisset

    @isset($rooms)
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Capacity
                </th>
                <th scope="col" class="px-6 py-3">
                   Location
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                   Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
                <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3 text-base font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="{{ route('room.show', $room->id) }}">
                            {{ $room->name }}
                        </a>
                    </td>
                    <td class="px-6 py-3">
                        {{ $room->capacity }}
                    </td>
                    <td class="px-6 py-3">
                        {{ $room->location }}
                    </td>
                    <td class="px-6 py-3 text-right">
                        <div class="inline-flex gap-3">
                            @can('room.update')
                            <a href="{{ route('room.edit', $room->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Edit">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            @endcan
                            @can('room.delete')
                            <form action="{{ route('room.destroy', $room->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this room?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-0 font-medium text-red-600 bg-transparent cursor-pointer dark:text-red-500 hover:underline" title="Delete">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
       <div class="mt-4">
    {{ $rooms->links() }}
    </div>
    @endisset

    @isset($students)
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Score
                </th>
                <th scope="col" class="px-6 py-3">
                    Register at
                </th>
                <th scope="col" class="px-6 py-3">
                    Modified at
                </th>
                <th scope="col" class="px-6 py-3">
                   Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3 text-base font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="{{ route('term.student.show', [$term, $student->student_id]) }}">
                            {{ $student->student->full_name }}
                        </a>
                    </td>
                    <td class="px-6 py-3">
                        {{ $student->score ?? 'Not assigned'}}
                    </td>
                    <td class="px-6 py-3">
                        {{ $student->created_at}}
                    </td>
                    <td class="px-6 py-3">
                        {{ $student->updated_at}}
                    </td>
                    <td class="px-6 py-3">
                        <div class="inline-flex gap-3">
                            {{-- @can('term-student.update', $student) --}}
                            <a href="{{ route('term.student.edit', [$term, $student->student_id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Edit">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('term-student.delete', $student) --}}
                            <form action="{{ route('term.student.destroy', [$term, $student->student_id]) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this student from the term?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-0 font-medium text-red-600 bg-transparent cursor-pointer dark:text-red-500 hover:underline" title="Delete">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </form>
                            {{-- @endcan --}}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endisset
</div>
