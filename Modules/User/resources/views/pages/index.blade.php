<x-user::layouts.master>
    <h1>Hello World</h1>

    <p>Module: {!! config('user.name') !!}</p>
    @php
        dd($users);
    @endphp
</x-user::layouts.master>
