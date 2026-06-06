@extends('layouts.app')
@section('title', 'Categorias')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Categorias</h1>
        <p class="page-subtitle">Gerencie as categorias de chamados do sistema</p>
    </div>
    <a href="{{ route('categorias.create') }}" class="btn btn-primary">
        + Nova Categoria
    </a>
</div>

<div class="table-wrap">
    <div class="table-header">
        <span class="table-title">{{ $categorias->count() }} categoria(s) cadastrada(s)</span>
    </div>

    @if($categorias->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🗂️</div>
            <div class="empty-text">Nenhuma categoria cadastrada ainda.</div>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $c)
                <tr>
                    <td style="font-weight:600; color:var(--text-primary);">{{ $c->nome }}</td>
                    <td>{{ $c->descricao ?? '—' }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('categorias.edit', $c) }}" class="btn btn-ghost btn-sm">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('categorias.destroy', $c) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Excluir a categoria {{ $c->nome }}?')">
                                    🗑 Excluir
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> UsuariosVitoria
