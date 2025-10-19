<x-user::layouts.master>
    <x-header headline="Users">
        <x-slot:actions>
            <x-button type="submit" form="userProfileForm" rounded="rounded-s-lg" variant="primary">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8"/>
                </svg>
                Save
            </x-button>
            <x-button href="{{ route('user.edit', $user->id) }}" variant="danger">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>
                </svg>
                Discard
            </x-button>
            <x-button href="{{ route('user.index') }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                Close
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-user::profile :user="$user">
        <form id="userProfileForm" action="{{ route('user.update', $user->id) }}" method="POST" class="w-full max-w-3/4 mx-auto py-10 grid grid-cols-3 gap-6">
            @csrf
            <x-input label="Name" name="first_name" value="{{ $user->first_name }}" :required="true"></x-input>
            <x-input label="Surname" name="last_name" value="{{ $user->last_name }}" :required="true"></x-input>
            <x-multiselect label="Roles" :user="$user" :roles="$roles"></x-multiselect>
            <x-input label="Degree" name="degree" value="{{ $user->degree }}"></x-input>
            <x-input label="Email" name="email" value="{{ $user->email }}" :required="true"></x-input>
            <x-input label="Bio" name="bio" value="{{ $user->bio }}" input="textarea"></x-input>
            <x-input label="Country" name="country" value="{{ $user->country }}"></x-input>
            <x-input label="Birth date" name="birth_date" value="{{ $user->birth_date->format('d.m.Y') }}" :required="true"></x-input>
        </form>
    </x-user::profile>
</x-user::layouts.master>