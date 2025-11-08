<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        @if(isset($course))
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $course->name }}</h2>
                <p class="text-gray-600 dark:text-gray-300">{{ $course->code }} - {{ $course->academic_year }}</p>
            </div>
        @elseif(isset($courseStudent))
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ $courseStudent->student->first_name }} {{ $courseStudent->student->last_name }}
                </h2>
                <p class="text-gray-600 dark:text-gray-300">Enrolled in {{ $courseStudent->course->name }}</p>
            </div>
        @elseif(isset($courseLecturer))
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ $courseLecturer->lecturer->first_name }} {{ $courseLecturer->lecturer->last_name }}
                </h2>
                <p class="text-gray-600 dark:text-gray-300">{{ $courseLecturer->role }} in {{ $courseLecturer->course->name }}</p>
            </div>
        @elseif(isset($courseNews))
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $courseNews->title }}</h2>
                <p class="text-gray-600 dark:text-gray-300">By {{ $courseNews->author->first_name }} {{ $courseNews->author->last_name }}</p>
            </div>
        @endif
        
        {{ $slot }}
    </div>
</div>
