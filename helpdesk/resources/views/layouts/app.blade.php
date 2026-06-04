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
            <a href="/">Dashboard</a>

            <a href="/tecnico/pendentes">
                Pendentes
            </a>

            <a href="/tecnico/em-atendimento">
                Em Atendimento
            </a>

            <a href="/tecnico/historico/1">
                Histórico
            </a>
        </nav>

    </aside>

    <main class="content">
        @yield('content')
    </main>

</div>

</body>
</html>