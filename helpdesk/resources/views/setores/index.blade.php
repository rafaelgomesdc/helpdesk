@extends('layouts.app')
@section('title', 'Setores')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Setores</h1>
        <p class="page-subtitle mb-0 text-secondary">Gerencie os setores da organização</p>
    </div>
    <a href="{{ route('setores.create') }}" class="btn btn-primary">➕ Novo Setor</a>
</div>

<div class="table-wrap">
    @if($setores->isEmpty())
        <div class="empty-state py-5">
            <div class="empty-icon fs-2">🏢</div>
            <div class="empty-text text-muted mt-2">Nenhum setor cadastrado.</div>
        </div>
    @else
        <div class="table-responsive">
            <table class="align-middle">
                <thead><tr><th style="width: 80px;">ID</th><th>Nome</th><th>Descrição</th><th>Cargos</th><th>Usuários</th><th style="width: 200px; text-align: center;">Ações</th></tr></thead>
                <tbody>
                    @foreach($setores as $s)
                    <tr>
                        <td class="font-mono text-muted small">{{ $s->id }}</td>
                        <td style="font-weight:600;color:var(--text-primary);">{{ $s->nome }}</td>
                        <td class="text-secondary small">{{ $s->descricao ?? '—' }}</td>
                        <td><span class="badge badge-blue">{{ $s->cargos_count }}</span></td>
                        <td><span class="badge badge-green">{{ $s->usuarios_count }}</span></td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('setores.edit', $s) }}" class="btn btn-ghost btn-sm">✏️ Editar</a>
                                <form action="{{ route('setores.destroy', $s) }}" method="POST" style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" onclick="return confirm('Excluir setor?')">🗑 Excluir</button>
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
