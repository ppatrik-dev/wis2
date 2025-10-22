<x-user::layouts.master>
    @guest
        "WiS2"
    @endguest
    @auth
   <span>Welcome, {{ Auth::user()->first_name }}!</span>
    <form action="{{ route('logout')}}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
    @endauth
</x-user::layouts.master>
