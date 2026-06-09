@extends('layouts.app')
@section('title', 'Categorias')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Categorias</h1>
        <p class="page-subtitle mb-0 text-secondary">Gerencie as categorias de chamados do sistema</p>
    </div>
    <a href="{{ route('categorias.create') }}" class="btn btn-primary">
        ➕ Nova Categoria
    </a>
</div>

<div class="table-wrap">
    @if($categorias->isEmpty())
        <div class="empty-state py-5">
            <div class="empty-icon fs-2">🗂️</div>
            <div class="empty-text text-muted mt-2">Nenhuma categoria cadastrada ainda.</div>
        </div>
    @else
        <div class="table-responsive">
            <table class="align-middle">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th style="width: 200px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $c)
                    <tr>
                        <td class="font-mono text-muted small">{{ $c->id }}</td>
                        <td style="font-weight:600; color:var(--text-primary);">{{ $c->nome }}</td>
                        <td class="text-secondary small">{{ $c->descricao ?? '—' }}</td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('categorias.edit', $c) }}" class="btn btn-ghost btn-sm">✏️ Editar</a>
                                <form action="{{ route('categorias.destroy', $c) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm"
                                        onclick="return confirm('Excluir a categoria {{ $c->nome }}?')">🗑 Excluir</button>
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
