@extends('layouts.app')
@section('title', 'Artigos')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Artigos</h1>
        <p class="page-subtitle">Base de conhecimento — artigos e tutoriais</p>
    </div>
    @if(session('user_role') == 'admin' || session('user_role') == 'technician')
        <a href="{{ route('artigos.create') }}" class="btn btn-primary">+ Novo Artigo</a>
    @endif
</div>

<div class="table-wrap">
    <div class="table-header">
        <span class="table-title">{{ $artigos->count() }} artigo(s) publicado(s)</span>
    </div>

    @if($artigos->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📄</div>
            <div class="empty-text">Nenhum artigo publicado ainda.</div>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Autor</th>
                    <th>Publicado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($artigos as $artigo)
                <tr>
                    <td style="color:var(--text-primary); font-weight:500;">
                        {{ Str::limit($artigo->titulo, 60) }}
                    </td>
                    <td>
                        @if($artigo->categoria)
                            <span class="badge">{{ $artigo->categoria->nome }}</span>
                        @else
                            <span style="color:var(--text-muted);">—</span>
                        @endif
                    </td>
                    <td>{{ $artigo->autor?->name ?? '—' }}</td>
                    <td style="font-family:'IBM Plex Mono',monospace; font-size:11px;">
                        {{ $artigo->created_at->format('d/m/Y') }}
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('artigos.show', $artigo) }}" class="btn btn-ghost btn-sm">👁 Ver</a>
                            @if(session('user_role') == 'admin' || session('user_role') == 'technician')
                                <a href="{{ route('artigos.edit', $artigo) }}" class="btn btn-ghost btn-sm">✏️ Editar</a>
                                <form method="POST" action="{{ route('artigos.destroy', $artigo) }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Excluir este artigo?')">🗑 Excluir</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
