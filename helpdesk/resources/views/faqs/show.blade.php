@extends('layouts.app')
@section('title', 'Visualizar FAQ')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span style="font-size: 20px;">❓</span>
            <h1 class="page-title mb-0" style="font-size: 20px;">Detalhes da FAQ</h1>
        </div>
        <p class="page-subtitle mb-0 text-secondary">
            Categoria: **{{ $faq->categoria?->nome ?? 'Geral' }}**
        </p>
    </div>
    <a href="{{ route('faqs.index') }}" class="btn btn-ghost">
        ← Voltar
    </a>
</div>

<div class="form-card" style="max-width: 100%;">
    <div class="p-3 mb-4 rounded" style="background-color: var(--bg-850); border-left: 4px solid var(--blue-500);">
        <h4 class="text-white mb-0" style="font-size: 15px; font-weight: 700; line-height: 1.5;">{{ $faq->pergunta }}</h4>
    </div>
    
    <h5 class="portal-label mb-2" style="color: var(--text-muted);">Resposta Sugerida</h5>
    <p class="text-secondary" style="line-height: 1.7; white-space: pre-wrap; font-size: 13.5px;">{{ $faq->resposta }}</p>

    @if(auth()->user()->isAdmin())
        <div class="border-top pt-3 mt-4 d-flex justify-content-end">
            <a href="{{ route('faqs.edit', $faq) }}" class="btn btn-primary">
                ✏️ Editar FAQ
            </a>
        </div>
    @endif
</div>

@endsection
