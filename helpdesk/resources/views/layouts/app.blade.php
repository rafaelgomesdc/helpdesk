<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Help Desk</title>

    <link rel="stylesheet" href="{{ asset('css/helpdesk.css') }}"> 
</head>
<body>

<div class="container">

    <aside class="sidebar">

        <div class="logo">
            🎧 Help Desk
        </div>

        <nav class="menu">
            <a href="#">Dashboard</a>
            <a href="#">Pendentes</a>
            <a href="#">Em Atendimento</a>
            <a href="#">Histórico</a>
        </nav>

    </aside>

    <main class="content">
        @yield('content')
    </main>

</div>

</body>
</html>