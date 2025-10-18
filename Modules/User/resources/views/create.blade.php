<x-user::layouts.master>
    <x-header headline="Users">
        <x-slot:actions>
            <x-button href="{{ route('user.store') }}" rounded="rounded-s-lg" variant="primary">
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
    
    <x-user::profile :photo="false">
        <x-input name="Name" required="true"></x-input>

        <x-input name="Surname" required="true"></x-input>

        <x-multiselect :roles="$roles"></x-multiselect>
        
        <x-input name="Degree"></x-input>
        
        <x-input name="Email" required="true"></x-input>

        <x-input name="Bio" input="textarea"></x-input>
        
        <x-input name="Country"></x-input>
        
        <x-input name="Birth date"></x-input>
        
        <x-input name="Password" type="password" required="true"></x-input>

        <x-input name="Confirm password" type="password" required="true"></x-input>
    </x-user::profile>
</x-user::layouts.master>