@props([
    'user' => null
])

<div class="bg-white border border-gray-200 rounded-lg shadow-sm max-w dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-col items-center w-full h-full py-6 rounded-t-lg bg-gray-50 dark:bg-gray-700">
        @if ($user)
            <x-avatar letters="{{ $user->initials }}" text='4xl' width='30' height='30'></x-avatar>
        @else
            <x-avatar width='30' height='30'></x-avatar>
        @endif
    </div>
    
    @if ($errors->any())
        <div class="p-4 text-red-700 bg-red-100 border border-red-400 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ $slot ?? '' }}
</div>
