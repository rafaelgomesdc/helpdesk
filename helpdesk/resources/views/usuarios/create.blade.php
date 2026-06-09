@extends('layouts.app')
@section('title', 'Novo Usuário')
@section('content')

<div class="page-header mb-4">
    <div>
        <h1 class="page-title mb-1">Novo Usuário</h1>
        <p class="page-subtitle mb-0 text-secondary">Cadastre um colaborador no sistema Helpdesk</p>
    </div>
</div>

<div class="form-card" style="max-width: 900px;">
    <div class="mb-4 p-3 rounded" style="background: rgba(59, 130, 246, 0.06); border: 1px solid rgba(59, 130, 246, 0.2); font-size: 12px; color: var(--text-secondary); line-height: 1.5;">
        <div class="d-flex gap-2">
            <span style="font-size: 16px;">📋</span>
            <div>
                <strong style="color: var(--blue-400);">Informações:</strong> Preencha os dados do colaborador. O e-mail será usado para login e notificações. A senha pode ser definida agora ou deixada em branco para que o usuário defina através do fluxo de recuperação.
            </div>
        </div>
    </div>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @include('usuarios._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar Usuário</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
