@extends('layouts.app')
@section('title', 'Setores')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Setores</h1>
        <p class="page-subtitle">Gerencie os setores da organização</p>
    </div>
    <a href="{{ route('setores.create') }}" class="btn btn-primary">+ Novo Setor</a>
</div>

<div class="table-wrap">
    @if($setores->isEmpty())
        <div class="empty-state"><div class="empty-icon">🏢</div><div class="empty-text">Nenhum setor cadastrado.</div></div>
    @else
        <table>
            <thead><tr><th>Nome</th><th>Descrição</th><th>Cargos</th><th>Usuários</th><th>Ações</th></tr></thead>
            <tbody>
                @foreach($setores as $s)
                <tr>
                    <td style="font-weight:600;color:var(--text-primary);">{{ $s->nome }}</td>
                    <td>{{ $s->descricao ?? '—' }}</td>
                    <td>{{ $s->cargos_count }}</td>
                    <td>{{ $s->usuarios_count }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('setores.edit', $s) }}" class="btn btn-ghost btn-sm">Editar</a>
                            <form action="{{ route('setores.destroy', $s) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Excluir setor?')">Excluir</button>
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
