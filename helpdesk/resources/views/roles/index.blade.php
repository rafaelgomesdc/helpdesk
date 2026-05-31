<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Perfis de Acesso</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen p-8">

<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Perfis de Acesso</h1>
            <p class="text-slate-400 text-sm">Gerencie os perfis do sistema.</p>
        </div>

        <a href="{{ route('roles.create') }}" class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded-xl text-white">
            Novo Perfil
        </a>
    </div>

    @if (session('success'))
        <div class="mb-5 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-950 text-slate-400">
                <tr>
                    <th class="text-left p-4">Nome</th>
                    <th class="text-left p-4">Descrição</th>
                    <th class="text-right p-4">Ações</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($roles as $role)
                    <tr class="border-t border-slate-800">
                        <td class="p-4 font-medium text-white">{{ $role->name }}</td>
                        <td class="p-4 text-slate-400">{{ $role->description }}</td>
                        <td class="p-4 text-right flex justify-end gap-2">
                            <a href="{{ route('roles.edit', $role->id) }}" class="px-3 py-1 rounded-lg bg-slate-800 hover:bg-slate-700">
                                Editar
                            </a>

                            <form method="POST" action="{{ route('roles.destroy', $role->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 rounded-lg bg-red-600 hover:bg-red-500 text-white">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-6 text-center text-slate-500">
                            Nenhum perfil cadastrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>