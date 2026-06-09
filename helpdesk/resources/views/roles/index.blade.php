@extends('layouts.app')
@section('title', 'Perfis de Acesso')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Perfis de Acesso</h1>
        <p class="page-subtitle mb-0 text-secondary">CRUD de perfis e controle de permissões</p>
    </div>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">➕ Novo Perfil</a>
</div>

<div class="table-wrap">
    @if($roles->isEmpty())
        <div class="empty-state py-5">
            <div class="empty-icon fs-2">🛡️</div>
            <div class="empty-text text-muted mt-2">Nenhum perfil cadastrado.</div>
        </div>
    @else
        <div class="table-responsive">
            <table class="align-middle">
                <thead><tr><th style="width: 80px;">ID</th><th>Nome</th><th>Descrição</th><th>Permissões</th><th style="width: 200px; text-align: center;">Ações</th></tr></thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td class="font-mono text-muted small">{{ $role->id }}</td>
                        <td style="font-weight:600;color:var(--text-primary);">{{ $role->name }}</td>
                        <td class="text-secondary small">{{ $role->description ?? '—' }}</td>
                        <td><span class="badge badge-blue">{{ $role->permissions_count }}</span></td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('roles.edit', $role) }}" class="btn btn-ghost btn-sm">✏️ Editar</a>
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" onclick="return confirm('Excluir perfil?')">🗑 Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
