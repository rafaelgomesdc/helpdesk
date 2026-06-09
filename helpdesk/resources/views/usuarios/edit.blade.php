@extends('layouts.app')
@section('title', 'Editar Usuário')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Editar Usuário</h1>
        <p class="page-subtitle mb-0 text-secondary">{{ $usuario->name }}</p>
    </div>
    <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-ghost">Ver detalhes</a>
</div>

<div class="form-card" style="max-width: 900px;">
    <div class="mb-4 p-3 rounded" style="background: rgba(251, 191, 36, 0.06); border: 1px solid rgba(251, 191, 36, 0.2); font-size: 12px; color: var(--text-secondary); line-height: 1.5;">
        <div class="d-flex gap-2">
            <span style="font-size: 16px;">⚠️</span>
            <div>
                <strong style="color: var(--amber-400);">Atenção:</strong> Ao alterar o perfil de acesso ou status do usuário, as permissões serão recalculadas automaticamente. Campos de senha e resposta de segurança podem ser deixados em branco para manter os valores atuais.
            </div>
        </div>
    </div>

    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf @method('PUT')
        @include('usuarios._form', ['usuario' => $usuario])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Atualizar Usuário</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
