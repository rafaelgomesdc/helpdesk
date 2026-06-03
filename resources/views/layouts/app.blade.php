<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Desk - Sistema de Chamados</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Menu de Navegação -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('users.index') }}">Help Desk</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">

                <!-- APARECE APENAS SE FOR ADMIN OU TÉCNICO -->
                @if(session('user_role') == 'admin' || session('user_role') == 'technician')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Usuários</a>
                    </li>
                @endif

                {{-- Usuário comum vê Meu Perfil --}}
                @if(session('user_role') == 'user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.show', session('user_id')) }}">Meu Perfil</a>
                    </li>
                @endif

                {{-- Só Admin vê Cargos e Setores --}}
                @if(session('user_role') == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cargos.index') }}">Cargos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('setores.index') }}">Setores</a>
                    </li>
                @endif

                {{-- Base de Conhecimento: visível para todos --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Base de Conhecimento
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('faqs.index') }}">FAQs</a></li>
                        <li><a class="dropdown-item" href="{{ route('artigos.index') }}">Artigos</a></li>
                        @if(session('user_role') == 'admin')
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('categorias.index') }}">Categorias</a></li>
                        @endif
                    </ul>
                </li>

            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link text-white">Olá, {{ session('user_name') }}</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('logout') }}" onclick="return confirm('Sair do sistema?')">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!-- Conteúdo Principal -->
    <div class="container">
        <!-- Mensagens de Sucesso / Erro -->
        @if(session('sucesso'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('sucesso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('erro'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('erro') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('aviso'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('aviso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- O conteúdo de cada tela vai aparecer aqui -->
        @yield('conteudo')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
