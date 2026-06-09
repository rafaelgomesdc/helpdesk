@extends('layouts.app')
@section('title', 'Permissões')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Permissões</h1>
        <p class="page-subtitle mb-0 text-secondary">Controle de permissões por perfil</p>
    </div>
    <a href="{{ route('permissions.create') }}" class="btn btn-primary">➕ Nova Permissão</a>
</div>

<div class="table-wrap">
    @if($permissions->isEmpty())
        <div class="empty-state py-5">
            <div class="empty-icon fs-2">🔐</div>
            <div class="empty-text text-muted mt-2">Nenhuma permissão cadastrada.</div>
        </div>
    @else
        <div class="table-responsive">
            <table class="align-middle">
                <thead><tr><th style="width: 80px;">ID</th><th>Nome</th><th>Descrição</th><th>Perfis</th><th style="width: 200px; text-align: center;">Ações</th></tr></thead>
                <tbody>
                    @foreach($permissions as $perm)
                    <tr>
                        <td class="font-mono text-muted small">{{ $perm->id }}</td>
                        <td style="font-weight:600;color:var(--text-primary);">{{ $perm->name }}</td>
                        <td class="text-secondary small">{{ $perm->description ?? '—' }}</td>
                        <td><span class="badge badge-blue">{{ $perm->roles_count }}</span></td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('permissions.edit', $perm) }}" class="btn btn-ghost btn-sm">✏️ Editar</a>
                                <form action="{{ route('permissions.destroy', $perm) }}" method="POST" style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" onclick="return confirm('Excluir permissão?')">🗑 Excluir</button>
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
