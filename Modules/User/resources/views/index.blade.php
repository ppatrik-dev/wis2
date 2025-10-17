<x-user::layouts.master>
    
    <h1 class="text-4xl text-white p-8">Users</h1>

    <x-user::table :users="$users" :roles="$roles" />

</x-user::layouts.master>