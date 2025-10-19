<div class="flex items-center gap-4 pl-3">
    <x-avatar width='8' height='8'></x-avatar>
    <div class="text-sm dark:text-white">
        <div>Name Surname</div>
    </div>

    <form method="POST" action="">
    @csrf
    <button type="submit"
        class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group">
        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
        </svg>
    </button>
</form>
</div>