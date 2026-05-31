<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Permissão</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-950 text-slate-200 min-h-screen p-8">

<div class="max-w-2xl mx-auto bg-slate-900 border border-slate-800 rounded-2xl p-8">

    <h1 class="text-3xl font-bold text-white mb-2">
        Editar Permissão
    </h1>

    <p class="text-slate-400 text-sm mb-8">
        Atualize os dados da permissão selecionada.
    </p>

    @if ($errors->any())
        <div class="mb-5 bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-xl text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('permissions.update', $permission->id) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm mb-2 text-slate-300">
                Nome
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name', $permission->name) }}"
                required
                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500"
            >
        </div>

        <div>
            <label class="block text-sm mb-2 text-slate-300">
                Descrição
            </label>

            <textarea
                name="description"
                rows="4"
                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500"
            >{{ old('description', $permission->description) }}</textarea>
        </div>

        <div class="flex gap-3">
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-500 px-5 py-3 rounded-xl text-white font-medium"
            >
                Atualizar
            </button>

            <a
                href="{{ route('permissions.index') }}"
                class="bg-slate-800 hover:bg-slate-700 px-5 py-3 rounded-xl text-white font-medium"
            >
                Voltar
            </a>
        </div>
    </form>

</div>

</body>
</html>