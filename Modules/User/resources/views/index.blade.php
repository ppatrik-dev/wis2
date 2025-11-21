<x-user::layouts.master>

    <x-header headline="Users" >
        <x-slot:actions>
            @role('admin')
            <x-button href="{{ route('user.create') }}" rounded="rounded-lg">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                </svg>
                Create User
            </x-button>
            @endrole
        </x-slot:actions>
    </x-header>
    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between my-2">
        <form method="GET" action="{{ route('user.index') }}"
                class="w-full flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-3">
            <div class="flex items-center gap-2">
                <label for="user-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>

                    <input type="text" id="user-search" name="query" value="{{ isset($query) ? e($query) : '' }}"
                        placeholder="Search users by name"
                        class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 ps-10 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" />
                </div>

                <button type="submit"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none dark:bg-blue-500 dark:hover:bg-blue-600  hover:cursor-pointer">
                    Search
                </button>

                @if(!empty($query))
                    <button name="query" value="" type="submit" onclick="{{ route('user.index') }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600 hover:cursor-pointer">
                        Clear
                    </button>
                @endif
            </div>

            <input hidden name="role" value="{{ $selectedRole }}"></input>
        
            <div class="flex-col gap-y-1">
                <button id="dropdownRoleButton" data-dropdown-toggle="dropdownRole" 
                        class="inline-flex justify-between items-center w-30 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100font-medium rounded-lg text-sm px-3 py-1.5
                        dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        type="button">
                    <span class="sr-only">Role button</span>
                    @if (!empty($selectedRole))
                        <span class="text-black dark:text-white">{{ ucfirst($selectedRole) }}</span>
                    @else
                        Select role
                    @endif

                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>

                <div id="dropdownRole" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-md shadow-sm w-30 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRoleButton">
                        <li>
                            <button type="submit" name="role" value=""
                                    class="w-full text-left px-5 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:cursor-pointer">
                                All
                            </button>
                        </li>

                        @foreach ($roles as $role)
                        <li>
                            <button type="submit" name="role" value="{{ $role->name }}"
                                    class="w-full text-left px-5 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:cursor-pointer">
                                {{ ucfirst($role->name) }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </form>
    </div>
    
    <x-user::table :users="$users" :roles="$roles" />

</x-user::layouts.master>
