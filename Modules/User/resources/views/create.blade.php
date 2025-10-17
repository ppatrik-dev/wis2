<x-user::layouts.master>

    <x-header headline="Users">
        <x-slot:actions>
            <x-button variant="primary" href="{{ route('user.store') }}">Save</x-button>
            <x-button variant="danger" href="{{ route('user.create') }}">Clear</x-button>
            <x-button variant="default" href="{{ route('user.index') }}">Close</x-button>
        </x-slot:actions>

    </x-header>
    <x-user::profile></x-user::profile>

</x-user::layouts.master>