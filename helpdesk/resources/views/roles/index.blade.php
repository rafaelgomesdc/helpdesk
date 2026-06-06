@extends('layouts.app')
@section('title', 'Perfis de Acesso')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Perfis de Acesso</h1>
        <p class="page-subtitle">CRUD de perfis e controle de permissões</p>
    </div>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">+ Novo Perfil</a>
</div>

<div class="table-wrap">
    @if($roles->isEmpty())
        <div class="empty-state"><div class="empty-icon">🛡️</div><div class="empty-text">Nenhum perfil cadastrado.</div></div>
    @else
        <table>
            <thead><tr><th>Nome</th><th>Descrição</th><th>Permissões</th><th>Ações</th></tr></thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td style="font-weight:600;color:var(--text-primary);">{{ $role->name }}</td>
                    <td>{{ $role->description ?? '—' }}</td>
                    <td>{{ $role->permissions_count }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-ghost btn-sm">Editar</a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Excluir perfil?')">Excluir</button>
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
