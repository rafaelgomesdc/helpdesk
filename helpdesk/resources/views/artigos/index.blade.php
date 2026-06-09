@extends('layouts.app')
@section('title', 'Base de Conhecimento')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Base de Conhecimento</h1>
        <p class="page-subtitle mb-0 text-secondary">Guias técnicos, documentações e manuais operacionais da empresa</p>
    </div>
    @if(auth()->user()->isAdmin() || auth()->user()->profile === 'Técnico')
        <a href="{{ route('artigos.create') }}" class="btn btn-primary">
            ➕ Novo Artigo
        </a>
    @endif
</div>

<!-- Filtros por Categoria -->
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('artigos.index') }}" class="btn btn-ghost btn-sm {{ !request()->has('categoria') ? 'active' : '' }}" style="background: var(--bg-800);">
        Todas
    </a>
    @foreach($categorias ?? [] as $cat)
        <a href="{{ route('artigos.index', ['categoria' => $cat->id]) }}" class="btn btn-ghost btn-sm {{ request('categoria') == $cat->id ? 'active' : '' }}" style="background: var(--bg-800);">
            {{ $cat->nome }}
        </a>
    @endforeach
</div>

<div class="row g-4">
    @forelse($artigos as $a)
        <div class="col-md-6 col-xxl-4">
            <div class="form-card h-100 d-flex flex-column justify-content-between" style="max-width: 100%; transition: transform 0.2s ease, border-color 0.2s ease;">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        @if($a->categoria)
                            <span class="badge badge-blue">{{ $a->categoria->nome }}</span>
                        @else
                            <span class="badge" style="background-color: var(--bg-800); color: var(--text-secondary);">Geral</span>
                        @endif
                        <span class="text-muted font-mono" style="font-size: 9px;">ID: {{ $a->id }}</span>
                    </div>

                    <h3 class="text-white mb-2" style="font-size: 15px; font-weight: 700; line-height: 1.4;">
                        {{ $a->titulo }}
                    </h3>

                    <p class="text-secondary small mb-3" style="line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                        {{ strip_tags($a->conteudo) }}
                    </p>
                </div>

                <div class="border-top pt-3 mt-2" style="border-color: var(--border) !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(99, 102, 241, 0.1)); font-size: 11px; color: var(--blue-400);">
                                {{ strtoupper(substr($a->autor?->name ?? '?', 0, 1)) }}
                            </div>
                            <span class="text-muted" style="font-size: 11px;">{{ $a->autor?->name ?? 'Sistema' }}</span>
                        </div>
                        <span class="text-muted small" style="font-size: 10.5px;">{{ $a->created_at?->format('d/m/Y') }}</span>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('artigos.show', $a) }}" class="btn btn-ghost btn-sm w-100 justify-content-center">
                            📖 Ler Artigo
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('artigos.edit', $a) }}" class="btn btn-ghost btn-sm" style="flex-shrink: 0;">
                                ✏️
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="table-wrap">
                <div class="empty-state py-5">
                    <div class="empty-icon fs-2">📚</div>
                    <div class="empty-text text-muted mt-2">Nenhum artigo publicado na Base de Conhecimento ainda.</div>
                </div>
            </div>
        </div>
    @endforelse
</div>

@endsection
