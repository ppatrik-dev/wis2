<x-course::layouts.master>
    <x-header headline="Edit Course">
        <x-slot:actions>
            <x-button type="submit" form="courseForm" rounded="rounded-s-lg" variant="primary">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8" />
                </svg>
                Save
            </x-button>
            <x-button href="{{ route('course.show', $course->id) }}" variant="danger">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3" />
                </svg>
                Discard
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

    <x-course::profile :course="$course">
        @if ($errors->any())
            <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form id="courseForm" action="{{ route('course.update', $course->id) }}" method="POST"
            class="grid w-full max-w-3xl grid-cols-3 gap-6 py-10 mx-auto">
            @csrf
            @method('PUT')
            <x-input label="Course Code" name="code" value="{{ $course->code }}" :required="true"></x-input>
            <x-input label="Course Name" name="name" value="{{ $course->name }}" :required="true"></x-input>
            <x-input label="Academic Year" name="academic_year" value="{{ $course->academic_year }}"
                :required="true"></x-input>
            <x-input label="Credits" name="credits" type="number" value="{{ $course->credits }}"
                :required="true"></x-input>
            <x-input label="Capacity" name="capacity" type="number" value="{{ $course->capacity }}"
                :required="true"></x-input>
            <x-select label="Type" name="type" :options="['mandatory' => 'Mandatory', 'optional' => 'Optional']"
                :selected="$course->type" :required="true"></x-select>
            @if(auth()->check() && auth()->user()->hasRole('admin'))
                <x-select label="Guarantor" name="guarantor_id" :options="$users"
                    :selected="$course->guarantor_id"></x-select>
            @else
                <x-input label="Guarantor" name="guarantor" value="{{ $course->guarantor ? $course->guarantor->first_name . ' ' . $course->guarantor->last_name : 'Not assigned' }}" :disabled="true"></x-input>
            @endif
                <x-toggle name="auto_enroll_confirm" label="Auto Enroll Confirm" :checked="$course->auto_enroll_confirm"/>
                @if(auth()->check() && auth()->user()->hasRole('admin'))
                    <x-toggle name="is_approved" label="Is Approved" :checked="$course->is_approved"/>
                @endif
            <x-input label="Description" name="description" value="{{ $course->description }}"
                input="textarea" class="col-span-3"></x-input>
        </form>
    </x-course::profile>
</x-course::layouts.master>
