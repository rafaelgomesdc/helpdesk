<h1>Login funcionou!</h1>

<p>Você está logado.</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Sair</button>
</form>