@props([
    'users' => [],
    'roles' => [],  
])

<div class="relative overflow-x-auto overflow-y-visible min-h-[300px]">
    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-3.5">
        <div>
            <button id="dropdownRoleButton" data-dropdown-toggle="dropdownRole" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 hover:bg-gray-100font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                <span class="sr-only">Role button</span>
                Role
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
        
            <div id="dropdownRole" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-30 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRoleButton">
       
                    @foreach ($roles as $role)
                        <li>
                            <a href="#" class="block px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ ucfirst($role->name) }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for users">
        </div>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Degree
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Gender
                </th>
                <th scope="col" class="px-6 py-3">
                    Birth date
                </th>
                <th scope="col" class="px-6 py-3">
                    Country
                </th>
                <th scope="col" class="px-6 py-3">
                    Role
                </th>
                <th scope="col" class="px-6 py-3">
                   Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3">
                        {{ $user->degree }}
                    </td>
                    <th scope="row" class="flex items-center px-6 py-3 text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="{{ route('user.show', $user->id) }}">
                            <x-avatar letters="{{ $user->getFullNameInitials() }}"></x-avatar>
                        </a>
                        <a href="{{ route('user.show', $user->id) }}" class="ps-3">
                            <div class="text-base font-semibold">{{ $user->getFullNameAttribute() }}</div>
                            <div class="font-normal text-gray-500">{{ $user->email }}</div>
                        </a>  
                    </th>
                    <td class="px-6 py-3">
                        {{ ucfirst($user->gender) }}
                    </td>
                    <td class="px-6 py-3">
                        {{ $user->birth_date->format('m/d/Y') }}
                    </td>
                    <td class="px-6 py-3">
                        {{ $user->country }}
                    </td>
                    <td class="px-6 py-3">
                        <div class="flex items-center">
                            @if ($user->getHighestRole())
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                            @endif
                            {{ ucfirst($user->getHighestRole()) }}
                        </div>
                    </td>
                    <td class="px-6 py-3">
                        <a href="{{ route('user.edit', $user->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline ms-3"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline bg-transparent p-0">
                                Remove
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
