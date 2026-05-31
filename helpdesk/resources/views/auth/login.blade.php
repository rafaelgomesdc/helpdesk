<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Portal HelpDesk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-950 text-slate-200 flex items-center justify-center p-6">

<div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 rounded-3xl overflow-hidden border border-slate-800 bg-slate-900 shadow-2xl">

    <div class="hidden md:flex flex-col justify-between p-10 bg-gradient-to-br from-blue-950 via-slate-950 to-slate-900">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-bold uppercase tracking-widest">
                ✨ Portal Corporativo
            </div>

            <h1 class="text-4xl font-bold text-white mt-8 leading-tight">
                Service Desk<br>
                <span class="text-blue-400">HelpDesk</span>
            </h1>

            <p class="text-slate-400 text-sm mt-4 leading-relaxed">
                Acesse o sistema para abrir chamados, acompanhar atendimentos,
                gerenciar usuários, permissões e suporte técnico.
            </p>
        </div>

        <div class="grid grid-cols-3 gap-3 text-center">
            <div class="bg-slate-950/70 border border-slate-800 rounded-2xl p-4">
                <div class="text-2xl">🛡️</div>
                <p class="text-xs mt-2 text-slate-400">Sessão Segura</p>
            </div>

            <div class="bg-slate-950/70 border border-slate-800 rounded-2xl p-4">
                <div class="text-2xl">👥</div>
                <p class="text-xs mt-2 text-slate-400">Perfis</p>
            </div>

            <div class="bg-slate-950/70 border border-slate-800 rounded-2xl p-4">
                <div class="text-2xl">🔑</div>
                <p class="text-xs mt-2 text-slate-400">Permissões</p>
            </div>
        </div>
    </div>

    <div class="p-8 md:p-10">

        <div class="mb-8">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-xl shadow-lg shadow-blue-500/20">
                🔐
            </div>

            <h2 class="text-2xl font-bold text-white mt-5">
                Entrar no Sistema
            </h2>

            <p class="text-slate-400 text-sm mt-2">
                Informe suas credenciais corporativas para acessar o portal.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 bg-red-500/10 border border-red-500/30 text-red-400 text-sm rounded-xl p-3">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-5 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm rounded-xl p-3">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.entrar') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    E-mail Corporativo
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="admin@helpdesk.com"
                    class="w-full bg-slate-950/70 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 placeholder-slate-500 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Senha
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    placeholder="Digite sua senha"
                    class="w-full bg-slate-950/70 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 placeholder-slate-500 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                >
            </div>

            <div class="flex items-center justify-between pt-1">
                <a href="#" class="text-xs text-slate-400 hover:text-slate-300 font-medium border-b border-dashed border-slate-700">
                    Esqueci minha senha
                </a>

                <div class="text-xs text-emerald-400 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sessão Segura
                </div>
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-medium py-3 rounded-xl transition-all shadow-lg hover:shadow-blue-500/10 flex items-center justify-center gap-2"
            >
                🔑 Entrar no Sistema
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-800/80">
            <div class="flex items-center gap-1.5 mb-3 text-xs font-semibold text-blue-400 uppercase tracking-widest">
                ✨ Acesso Rápido de Teste
            </div>

            <p class="text-slate-500 text-[11px] leading-normal mb-4">
                Use apenas para apresentação/teste do trabalho.
            </p>

            <div class="grid grid-cols-3 gap-2">
                <form method="POST" action="{{ route('login.teste') }}">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <button class="w-full px-2 py-2 bg-slate-950 hover:bg-blue-600/10 border border-slate-800 hover:border-blue-500/40 rounded-xl text-xs font-medium text-slate-300 hover:text-white transition-all flex flex-col items-center gap-1">
                        🧑‍💼 <span>Admin</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('login.teste') }}">
                    @csrf
                    <input type="hidden" name="role" value="technician">
                    <button class="w-full px-2 py-2 bg-slate-950 hover:bg-blue-600/10 border border-slate-800 hover:border-blue-500/40 rounded-xl text-xs font-medium text-slate-300 hover:text-white transition-all flex flex-col items-center gap-1">
                        👥 <span>Técnico</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('login.teste') }}">
                    @csrf
                    <input type="hidden" name="role" value="user">
                    <button class="w-full px-2 py-2 bg-slate-950 hover:bg-blue-600/10 border border-slate-800 hover:border-blue-500/40 rounded-xl text-xs font-medium text-slate-300 hover:text-white transition-all flex flex-col items-center gap-1">
                        ❔ <span>Usuário</span>
                    </button>
                </form>
            </div>


            
        </div>

    </div>
</div>

</body>
</html>