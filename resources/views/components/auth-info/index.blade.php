<div class="flex items-center gap-4 pl-3">
    @auth
        <x-avatar width='8' height='8'></x-avatar>
        <div class="text-sm dark:text-white">
            <a href="{{ route('user.show', auth()->user()->id) }}" class="hover:underline">
                {{ auth()->user()->full_name }}
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group">
                <svg class="w-5 h-5 text-gray-500 transition duration-75 shrink-0 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                </svg>
            </button>
        </form>
    @else
        <div class="text-sm">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-3 text-gray-600 hover:underline">Register</a>
            @endif
        </div>
    @endauth
</div>