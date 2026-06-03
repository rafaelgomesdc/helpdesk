@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Artigos da Base de Conhecimento</h2>
    @if(session('user_role') == 'admin' || session('user_role') == 'technician')
        <a href="{{ route('artigos.create') }}" class="btn btn-primary">+ Novo Artigo</a>
    @endif
</div>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Autor</th>
                    <th>Publicado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($artigos as $artigo)
                <tr>
                    <td>{{ Str::limit($artigo->titulo, 60) }}</td>
                    <td>{{ $artigo->categoria?->nome ?? '-' }}</td>
                    <td>{{ $artigo->autor?->name ?? '-' }}</td>
                    <td>{{ $artigo->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('artigos.show', $artigo) }}" class="btn btn-sm btn-outline-info">Ver</a>
                        @if(session('user_role') == 'admin' || session('user_role') == 'technician')
                            <a href="{{ route('artigos.edit', $artigo) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form method="POST" action="{{ route('artigos.destroy', $artigo) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Excluir este artigo?')">Excluir</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Nenhum artigo publicado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
