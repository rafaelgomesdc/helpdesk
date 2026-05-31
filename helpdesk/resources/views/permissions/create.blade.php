<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nova Permissão</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen p-8">

<div class="max-w-2xl mx-auto bg-slate-900 p-8 rounded-2xl">

    <h1 class="text-3xl font-bold mb-6">
        Nova Permissão
    </h1>

    <form method="POST" action="{{ route('permissions.store') }}">
        @csrf

        <div class="mb-4">
            <label>Nome</label>
            <input
                type="text"
                name="name"
                class="w-full bg-slate-800 rounded-xl p-3">
        </div>

        <div class="mb-6">
            <label>Descrição</label>
            <textarea
                name="description"
                class="w-full bg-slate-800 rounded-xl p-3"></textarea>
        </div>

        <button
            class="bg-blue-600 px-5 py-3 rounded-xl">
            Salvar
        </button>

    </form>
</div>

</body>
</html>