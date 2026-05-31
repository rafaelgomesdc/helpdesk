<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen p-8">

<div class="max-w-2xl mx-auto bg-slate-900 border border-slate-800 rounded-2xl p-8">
    <h1 class="text-3xl font-bold text-white mb-2">Novo Perfil</h1>
    <p class="text-slate-400 text-sm mb-8">Cadastre um perfil de acesso.</p>

    <form method="POST" action="{{ route('roles.store') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm mb-2">Nome</label>
            <input name="name" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3">
        </div>

        <div>
            <label class="block text-sm mb-2">Descrição</label>
            <textarea name="description" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3"></textarea>
        </div>

        <div class="flex gap-3">
            <button class="bg-blue-600 hover:bg-blue-500 px-5 py-3 rounded-xl">
                Salvar
            </button>

            <a href="{{ route('roles.index') }}" class="bg-slate-800 hover:bg-slate-700 px-5 py-3 rounded-xl">
                Voltar
            </a>
        </div>
    </form>
</div>

</body>
</html>