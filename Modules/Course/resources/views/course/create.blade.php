<x-course::layouts.master>
    <x-header headline="Create Course">
        <x-slot:actions>
            <x-button type="submit" form="courseForm" rounded="rounded-s-lg" variant="primary">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8" />
                </svg>
                Save
            </x-button>

            <x-button href="{{ route('course.create') }}" variant="danger">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9h13a5 5 0 0 1 0 10H7M3 9l4-4M3 9l4 4" />
                </svg>
                Clear
            </x-button>

            <x-button href="{{ route('course.index') }}" rounded="rounded-e-lg">
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

        <form id="courseForm" action="{{ route('course.store') }}" method="POST"
            class="grid w-full grid-cols-3 gap-6 py-10 mx-auto max-w-3/4">
            @csrf
            <x-input label="Course Code" name="code" :required="true" placeholder="e.g., IZP" maxlength="3"></x-input>
            <x-input label="Course Name" name="name" :required="true"
                placeholder="e.g., Introduction to Computer Science"></x-input>
            <x-input label="Academic Year" name="academic_year" :required="true"
                placeholder="e.g., 2024/2025"></x-input>
            <x-input label="Credits" name="credits" type="number" :required="true" placeholder="e.g., 7"></x-input>
            <x-input label="Capacity" name="capacity" type="number" :required="true" placeholder="e.g., 50"></x-input>
            <x-select label="Type" name="type" :options="['mandatory' => 'Mandatory', 'optional' => 'Optional']"
                :required="true" value="mandatory"></x-select>
            <x-select label="Guarantor" name="guarantor_id" :options="$users" :required="false"></x-select>
            <x-input type="checkbox" label="Auto Enroll Confirm" name="auto_enroll_confirm" value="1" />
            <x-input type="checkbox" label="Is Approved" name="is_approved" value="1" />
            <x-input label="Description" name="description" input="textarea"
                placeholder="Course description..."></x-input>
        </form>
    </x-course::profile>
</x-course::layouts.master>