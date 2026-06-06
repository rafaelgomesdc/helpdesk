@extends('layouts.app')
@section('title', 'Cargos')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Cargos</h1>
        <p class="page-subtitle">Gerencie os cargos e funções</p>
    </div>
    <a href="{{ route('cargos.create') }}" class="btn btn-primary">+ Novo Cargo</a>
</div>

<div class="table-wrap">
    @if($cargos->isEmpty())
        <div class="empty-state"><div class="empty-icon">💼</div><div class="empty-text">Nenhum cargo cadastrado.</div></div>
    @else
        <table>
            <thead><tr><th>Nome</th><th>Setor</th><th>Descrição</th><th>Usuários</th><th>Ações</th></tr></thead>
            <tbody>
                @foreach($cargos as $c)
                <tr>
                    <td style="font-weight:600;color:var(--text-primary);">{{ $c->nome }}</td>
                    <td>{{ $c->setor?->nome ?? '—' }}</td>
                    <td>{{ $c->descricao ?? '—' }}</td>
                    <td>{{ $c->usuarios_count }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('cargos.edit', $c) }}" class="btn btn-ghost btn-sm">Editar</a>
                            <form action="{{ route('cargos.destroy', $c) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Excluir cargo?')">Excluir</button>
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
