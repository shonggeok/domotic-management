<form id="logout-form" action="{{ Route('logout') }}" method="post">
    @csrf
    <button type="submit">Logout</button>
</form>