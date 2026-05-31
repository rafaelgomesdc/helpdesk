<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Permissões</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen p-8">

<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Permissões</h1>
            <p class="text-slate-400 text-sm">Gerencie as permissões do sistema.</p>
        </div>

        <a href="{{ route('permissions.create') }}"
           class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded-xl text-white">
            Nova Permissão
        </a>
    </div>

    <table class="w-full bg-slate-900 rounded-xl overflow-hidden">
        <thead>
            <tr class="bg-slate-800">
                <th class="p-4 text-left">Nome</th>
                <th class="p-4 text-left">Descrição</th>
                <th class="p-4 text-right">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr class="border-t border-slate-800">
                <td class="p-4">{{ $permission->name }}</td>
                <td class="p-4">{{ $permission->description }}</td>
                <td class="p-4 text-right">
                    <a href="{{ route('permissions.edit', $permission->id) }}"
                       class="text-blue-400">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>