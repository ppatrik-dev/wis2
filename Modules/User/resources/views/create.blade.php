<x-user::layouts.master>
    <x-header headline="Users">
        <x-slot:actions>
            <x-button type="submit" form="userProfileForm" rounded="rounded-s-lg" variant="primary">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8"/>
                </svg>
                Save
            </x-button>

            <x-button href="{{ route('user.create') }}" variant="danger">
                <svg class="w-4 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h13a5 5 0 0 1 0 10H7M3 9l4-4M3 9l4 4"/>
                </svg>
                Clear
            </x-button>

            <x-button href="{{ route('user.index') }}" rounded="rounded-e-lg">
                <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                Close
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-user::profile>
        <form id="userProfileForm" action="{{ route('user.store') }}" method="POST" class="grid w-full grid-cols-3 gap-6 py-10 mx-auto max-w-3/4">
            @csrf
            <x-input label="Name" name="first_name" :required="true"></x-input>
            <x-input label="Surname" name="last_name" :required="true"></x-input>
            <x-multiselect label="Roles" name="roles[]" :options="$roles" :selected="collect('user')"></x-multiselect>
            <x-input label="Degree" name="degree"></x-input>
            <x-input label="Email" name="email" :required="true"></x-input>
            <x-input label="Bio" name="bio" input="textarea"></x-input>
            <x-input label="Country" name="country"></x-input>
            <x-input label="Birth date" name="birth_date" :required="true"></x-input>
            <x-input label="Gender" name="gender" :required="true"></x-input>
            <x-input label="Password" name="password" type="password" :required="true"></x-input>
            <x-input label="Confirm password" name="password_confirmation" type="password" :required="true"></x-input>
        </form>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('userProfileForm');
            const pass = document.getElementById('input-password');
            const confirm = document.getElementById('input-password_confirmation');

            form.addEventListener('submit', e => {
                if (pass.value.length < 8) {
                    e.preventDefault();
                    alert('Password must be at least 8 characters long.');
                    pass.focus();
                    return;
                }

                if (pass.value !== confirm.value) {
                    e.preventDefault();
                    alert('Passwords do not match.');
                    confirm.focus();
                    return;
                }
            });
        });
        </script>
    </x-user::profile>
</x-user::layouts.master>
