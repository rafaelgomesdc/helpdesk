@extends('layouts.app')
@section('title', $artigo->titulo)
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span style="font-size: 20px;">📚</span>
            <h1 class="page-title mb-0" style="font-size: 20px;">{{ $artigo->titulo }}</h1>
        </div>
        <p class="page-subtitle mb-0 text-secondary">
            Categoria: **{{ $artigo->categoria?->nome ?? 'Geral' }}** · Autor: **{{ $artigo->autor?->name ?? 'Sistema' }}** · Publicado em **{{ $artigo->created_at?->format('d/m/Y H:i') }}**
        </p>
    </div>
    <a href="{{ route('artigos.index') }}" class="btn btn-ghost">
        ← Voltar
    </a>
</div>

<div class="form-card" style="max-width: 900px; background-color: var(--bg-900);">
    <!-- Conteúdo do Artigo Formatado -->
    <div style="line-height: 1.8; color: var(--text-secondary); font-size: 14px; white-space: pre-wrap;">{!! preg_replace('/^#{1,6}\s+(.*)$/m', '$1', $artigo->conteudo) !!}</div>

    @if(auth()->user()->isAdmin() || (auth()->user()->profile === 'Técnico' && $artigo->author_id === auth()->id()))
        <div class="border-top pt-3 mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('artigos.edit', $artigo) }}" class="btn btn-primary">
                ✏️ Editar Artigo
            </a>
            @if(auth()->user()->isAdmin())
                <form action="{{ route('artigos.destroy', $artigo) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Tem certeza que deseja excluir este artigo permanentemente?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        🗑️ Excluir Artigo
                    </button>
                </form>
            @endif
        </div>
    @endif
</div>

@endsection
