@props([
    'user' => null
])

@if ($errors->any())
    <div class="errors">
        @foreach ($errors->all() as $index => $error)
            <x-alert type="error" message="{{ $error }}" color="red" id="{{ $index }}"></x-alert>
        @endforeach
    </div>
@endif

<div class="bg-white border border-gray-200 rounded-lg shadow-sm max-w dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-col items-center w-full py-4 rounded-t-lg bg-gray-50 dark:bg-gray-700">
        @if ($user)
            <x-avatar letters="{{ $user->initials }}" text='4xl' width='60' height='60'></x-avatar>
        @else
            <label for="dropzone-file" class="flex flex-col items-center justify-center py-5 mx-auto border-2 border-gray-500 border-dashed rounded-full cursor-pointer w-60 h-60 hover:border-blue-500 dark:hover:border-blue-500 dark:bg-gray-800">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                    </svg>
                    <p class="mb-2 text-sm text-center text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                </div>
                <input id="dropzone-file" type="file" class="hidden" />
            </label>
        @endif
    </div>
    {{ $slot ?? '' }}
</div>
