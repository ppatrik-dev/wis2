<x-course::layouts.master>
    <x-header headline="Enroll Student">
        <x-slot:actions>
            <x-button type="submit" form="studentForm" rounded="rounded-s-lg" variant="primary">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8" />
                </svg>
                Enroll
            </x-button>

            <x-button href="{{ route('course.student.create', $courseId) }}" variant="danger">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9h13a5 5 0 0 1 0 10H7M3 9l4-4M3 9l4 4" />
                </svg>
                Clear
            </x-button>

            <x-button href="{{ route('course.student.index', $courseId) }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
                Close
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-course::profile>
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form id="studentForm" action="{{ route('course.student.store', $courseId) }}" method="POST"
            class="grid w-full grid-cols-3 gap-6 py-10 mx-auto max-w-3/4">
            @csrf
            <div>
                <x-input label="Student ID" name="student_id" type="number" :required="true"
                    placeholder="Enter student ID"></x-input>
                <div id="student-id-hint" class="mt-2 text-sm text-gray-600">Enter an ID to see the student's name</div>
            </div>
            <x-input label="Grade" name="final_score" type="number" min="0" max="100"
                placeholder="Enter grade"></x-input>
            <x-input type="checkbox" label="Approved" name="is_approved" value="1" :checked="false" />
        </form>

        <script>
            (function () {
                const input = document.querySelector('input[name="student_id"]');
                const hint = document.getElementById('student-id-hint');
                if (!input || !hint) return;

                const url = '{{ route('course.student.lookup', $courseId) }}';

                let timer = null;
                function setHint(text, cls) {
                    hint.textContent = text;
                    hint.className = (cls || 'mt-2 text-sm') + ' ' + (cls === 'error' ? 'text-red-600' : 'text-gray-600');
                }

                input.addEventListener('input', function (e) {
                    const v = e.target.value.trim();
                    clearTimeout(timer);
                    if (!v) {
                        setHint('Enter an ID to see the student\'s name');
                        return;
                    }

                    // debounce
                    timer = setTimeout(() => {
                        fetch(url + '?id=' + encodeURIComponent(v), {
                            credentials: 'same-origin'
                        }).then(resp => resp.text())
                            .then(text => {
                                const t = (text || '').trim();
                                if (t.length > 0) {
                                    setHint('Found: ' + t);
                                } else {
                                    setHint('User not found', 'error');
                                }
                            }).catch(err => {
                                console.debug('Error during student lookup', err);
                                setHint('User not found', 'error');
                            });
                    }, 300);
                });
            })();
        </script>
    </x-course::profile>
</x-course::layouts.master>