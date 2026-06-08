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

<div style="background:var(--bg-900); border:1px solid var(--border); border-radius:14px; padding:28px;">
    <div style="font-size:12px; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; margin-bottom:24px;">
        Por {{ $artigo->autor?->name ?? 'Desconhecido' }}
        · {{ $artigo->created_at->format('d/m/Y \à\s H:i') }}
        @if($artigo->updated_at->ne($artigo->created_at))
            · Atualizado em {{ $artigo->updated_at->format('d/m/Y H:i') }}
        @endif
    </div>

    <div style="border-top:1px solid var(--border); padding-top:24px; font-size:14px; color:var(--text-secondary); line-height:1.8; white-space:pre-wrap;">
        {{ $artigo->conteudo }}
    </div>

    @if(auth()->user()->isAdmin() || auth()->user()->profile === 'Technician')
        <div style="border-top:1px solid var(--border); padding-top:20px; margin-top:24px; display:flex; gap:8px;">
            <a href="{{ route('artigos.edit', $artigo) }}" class="btn btn-ghost">✏️ Editar</a>
            <form method="POST" action="{{ route('artigos.destroy', $artigo) }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Excluir este artigo?')">🗑 Excluir</button>
            </form>
        </div>
    @endif
</div>

@endsection
