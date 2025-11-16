<x-course::layouts.master>
    <x-header headline="My courses">
        <x-slot:actions>
        </x-slot:actions>
    </x-header>
    <x-course::table :myCourses="$courses" />

</x-course::layouts.master>
