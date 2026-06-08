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

<div class="detail-card">
    <div style="display:flex; gap:12px; margin-bottom:24px; flex-wrap:wrap;">
        @if($faq->categoria)
            <span class="badge">{{ $faq->categoria->nome }}</span>
        @endif
        <span class="detail-meta">Criado em {{ $faq->created_at->format('d/m/Y \à\s H:i') }}</span>
    </div>

    <div style="margin-bottom:24px;">
        <div class="detail-section-label">Pergunta</div>
        <div class="detail-text">{{ $faq->pergunta }}</div>
    </div>

    <div style="border-top:1px solid var(--border); padding-top:20px; margin-bottom:24px;">
        <div class="detail-section-label">Resposta</div>
        <div class="detail-text">{{ $faq->resposta }}</div>
    </div>

    @if(session('user_role') == 'admin' || session('user_role') == 'technician')
        <div style="border-top:1px solid var(--border); padding-top:20px; display:flex; gap:8px;">
            <a href="{{ route('faqs.edit', $faq) }}" class="btn btn-ghost">✏️ Editar</a>
            <form method="POST" action="{{ route('faqs.destroy', $faq) }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Excluir esta FAQ?')">🗑 Excluir</button>
            </form>
        </div>
    @endif
</div>

@endsection
