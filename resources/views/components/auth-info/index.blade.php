<div class="flex items-center gap-4 pl-3">
    @auth
        {{-- Avatar + meno --}}
            <div class="flex items-center space-x-3">
                <x-avatar width="8" height="8" />

                <div class="text-sm leading-tight dark:text-white">
                    <a href="{{ route('user.show', auth()->id()) }}"
                    class="block font-medium hover:underline">
                        {{ auth()->user()->full_name }}
                    </a>
                </div>
            </div>


        {{-- Logout button --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center justify-center text-gray-500 transition rounded-full w-9 h-9 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                </svg>
            </button>
        </form>
    @else
        {{-- Login & Register buttons --}}
        <div class="flex items-center gap-3 text-sm">
            <a href="{{ route('login') }}"
               class="px-4 py-1.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                Login
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="px-4 py-1.5 rounded-lg border border-gray-300 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Register
                </a>
            @endif
        </div>
    @endauth
</div>
