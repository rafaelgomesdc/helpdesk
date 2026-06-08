@extends('layouts.app')
@section('title', 'FAQ')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Detalhes da FAQ</h1>
        @if($faq->categoria)
            <p class="page-subtitle">Categoria: {{ $faq->categoria->nome }}</p>
        @endif
    </div>
    <a href="{{ route('faqs.index') }}" class="btn btn-ghost">← Voltar</a>
</div>

<div style="background:var(--bg-900); border:1px solid var(--border); border-radius:14px; padding:28px;">
    <div style="font-size:12px; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; margin-bottom:20px;">
        Criado em {{ $faq->created_at->format('d/m/Y \à\s H:i') }}
    </div>

    <div style="margin-bottom:24px;">
        <div style="font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; margin-bottom:8px;">Pergunta</div>
        <div style="font-size:14px; color:var(--text-secondary); line-height:1.8;">{{ $faq->pergunta }}</div>
    </div>

    <div style="border-top:1px solid var(--border); padding-top:20px; margin-bottom:24px;">
        <div style="font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; margin-bottom:8px;">Resposta</div>
        <div style="font-size:14px; color:var(--text-secondary); line-height:1.8; white-space:pre-wrap;">{{ $faq->resposta }}</div>
    </div>

    @if(auth()->user()->isAdmin() || auth()->user()->profile === 'Technician')
        <div style="border-top:1px solid var(--border); padding-top:20px; display:flex; gap:8px;">
            <a href="{{ route('faqs.edit', $faq) }}" class="btn btn-ghost">✏️ Editar</a>
            <form method="POST" action="{{ route('faqs.destroy', $faq) }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Excluir esta FAQ?')">🗑 Excluir</button>
            </form>
        </div>
    @endif
</div>

@endsection
