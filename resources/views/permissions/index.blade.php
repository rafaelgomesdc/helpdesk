@extends('layouts.app')
@section('title', 'Permissões')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Permissões</h1>
        <p class="page-subtitle">Controle de permissões por perfil</p>
    </div>
    <a href="{{ route('permissions.create') }}" class="btn btn-primary">+ Nova Permissão</a>
</div>

<div class="table-wrap">
    @if($permissions->isEmpty())
        <div class="empty-state"><div class="empty-icon">🔐</div><div class="empty-text">Nenhuma permissão cadastrada.</div></div>
    @else
        <table>
            <thead><tr><th>Nome</th><th>Descrição</th><th>Perfis</th><th>Ações</th></tr></thead>
            <tbody>
                @foreach($permissions as $perm)
                <tr>
                    <td style="font-weight:600;color:var(--text-primary);">{{ $perm->name }}</td>
                    <td>{{ $perm->description ?? '—' }}</td>
                    <td>{{ $perm->roles_count }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('permissions.edit', $perm) }}" class="btn btn-ghost btn-sm">Editar</a>
                            <form action="{{ route('permissions.destroy', $perm) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Excluir permissão?')">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
