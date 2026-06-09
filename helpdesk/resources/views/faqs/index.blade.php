@extends('layouts.app')
@section('title', 'FAQs')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Perguntas Frequentes (FAQs)</h1>
        <p class="page-subtitle mb-0 text-secondary">Respostas rápidas para as dúvidas mais comuns dos colaboradores</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('faqs.create') }}" class="btn btn-primary">
            ➕ Nova FAQ
        </a>
    @endif
</div>

<!-- Filtros por Categoria -->
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('faqs.index') }}" class="btn btn-ghost btn-sm {{ !request()->has('categoria') ? 'active' : '' }}" style="background: var(--bg-800);">
        Todas
    </a>
    @foreach($categorias ?? [] as $cat)
        <a href="{{ route('faqs.index', ['categoria' => $cat->id]) }}" class="btn btn-ghost btn-sm {{ request('categoria') == $cat->id ? 'active' : '' }}" style="background: var(--bg-800);">
            {{ $cat->nome }}
        </a>
    @endforeach
</div>

<div class="row g-4">
    @forelse($faqs as $f)
        <div class="col-md-6 col-lg-4">
            <div class="form-card h-100 d-flex flex-column" style="max-width: 100%; transition: transform 0.2s ease, border-color 0.2s ease;">
                <div class="d-flex align-items-start justify-content-between gap-2 mb-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(99, 102, 241, 0.1)); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                            ❓
                        </div>
                        <h4 class="text-white mb-0" style="font-size: 14px; font-weight: 700; line-height: 1.4;">{{ $f->pergunta }}</h4>
                    </div>
                    @if($f->categoria)
                        <span class="badge badge-blue" style="font-size: 10px;">{{ $f->categoria->nome }}</span>
                    @endif
                </div>
                
                <p class="text-secondary small mb-4" style="line-height: 1.6; flex-grow: 1;">
                    {{ \Illuminate\Support\Str::limit($f->resposta, 150) }}
                </p>

                <div class="d-flex justify-content-between align-items-center border-top pt-3" style="border-color: var(--border) !important;">
                    <a href="{{ route('faqs.show', $f) }}" class="btn btn-ghost btn-sm">
                        📖 Ler Completo
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('faqs.edit', $f) }}" class="btn btn-ghost btn-sm">
                            ✏️ Editar
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="table-wrap">
                <div class="empty-state py-5">
                    <div class="empty-icon fs-2">❔</div>
                    <div class="empty-text text-muted mt-2">Nenhuma pergunta frequente cadastrada no momento.</div>
                </div>
            </div>
        </div>
    @endforelse
</div>


@endsection
