<x-user::layouts.master>
    
    <x-header headline="Users" >
        <x-slot:actions>
            <x-button variant="primary" href="{{ route('user.create') }}">Create</x-button>
        </x-slot:actions>
    </x-header>

    <x-user::table :users="$users" :roles="$roles" />

</x-user::layouts.master>