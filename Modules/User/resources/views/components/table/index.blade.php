@props([
    'users' => [],
    'roles' => [],
])

<div class="relative overflow-x-auto overflow-y-visible">
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
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
                @role('admin')
                <th scope="col" class="px-6 py-3">
                   Actions
                </th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3">
                        {{ $user->degree }}
                    </td>
                    <th scope="row" class="flex items-center px-6 py-3 text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="{{ route('user.show', $user->id) }}" class="w-10 h-10" >
                            <x-avatar letters="{{ $user->initials }}"  width="40" height="40"></x-avatar>
                        </a>
                        <a href="{{ route('user.show', $user->id) }}" class="ps-3">
                            <div class="text-base font-semibold">{{ $user->first_name }} {{ $user->last_name }}</div>
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
                            @if ($user->highest_role)
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                            @endif
                            {{ ucfirst($user->highest_role) }}
                        </div>
                    </td>
                       @role('admin')
                    <td class="inline-flex px-6 py-3 gap-3">

                        <a href="{{ route('user.edit', $user->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Edit">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                            </svg>
                        </a>


                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline" title="Delete"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-0 font-medium text-red-600 bg-transparent cursor-pointer dark:text-red-500 hover:underline">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 8 0 4 4 0 0 1-8 0Zm-2 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1Zm13-6a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-4Z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </form>

                    </td>
                          @endrole
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-2">
        {{ $users->links() }}
    </div>
</div>
