@extends('layouts.app')
@section('title', $artigo->titulo)
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">{{ $artigo->titulo }}</h1>
        @if($artigo->categoria)
            <p class="page-subtitle">{{ $artigo->categoria->nome }}</p>
        @endif
    </div>
    <a href="{{ route('artigos.index') }}" class="btn btn-ghost">← Voltar</a>
</div>

<div class="detail-card">
    <div style="display:flex; gap:12px; align-items:center; margin-bottom:24px; flex-wrap:wrap;">
        @if($artigo->categoria)
            <span class="badge">{{ $artigo->categoria->nome }}</span>
        @endif
        <span class="detail-meta">
            Por {{ $artigo->autor?->name ?? 'Desconhecido' }}
            · {{ $artigo->created_at->format('d/m/Y \à\s H:i') }}
            @if($artigo->updated_at->ne($artigo->created_at))
                · Atualizado em {{ $artigo->updated_at->format('d/m/Y H:i') }}
            @endif
        </span>
    </div>

    <div style="border-top:1px solid var(--border); padding-top:24px;">
        <div class="detail-text">{{ $artigo->conteudo }}</div>
    </div>

    @if(session('user_role') == 'admin' || session('user_role') == 'technician')
        <div style="border-top:1px solid var(--border); padding-top:20px; margin-top:24px; display:flex; gap:8px;">
            <a href="{{ route('artigos.edit', $artigo) }}" class="btn btn-ghost">✏️ Editar</a>
            <form method="POST" action="{{ route('artigos.destroy', $artigo) }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Excluir este artigo?')">🗑 Excluir</button>
            </form>
        </div>
    @endif
</div>

@endsection
