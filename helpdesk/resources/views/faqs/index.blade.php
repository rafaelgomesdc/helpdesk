@extends('layouts.app')
@section('title', 'FAQs')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">FAQs</h1><p class="page-subtitle">Perguntas frequentes</p></div>
    @if(auth()->user()->isAdmin())<a href="{{ route('faqs.create') }}" class="btn btn-primary">+ Nova FAQ</a>@endif
</div>
<div class="table-wrap">
    @forelse($faqs as $f)
        <div style="padding:20px;border-bottom:1px solid var(--border);">
            <strong style="color:var(--text-primary);">{{ $f->pergunta }}</strong>
            <p style="margin-top:8px;color:var(--text-secondary);">{{ \Illuminate\Support\Str::limit($f->resposta, 200) }}</p>
            <div style="margin-top:10px;display:flex;gap:8px;">
                <a href="{{ route('faqs.show', $f) }}" class="btn btn-ghost btn-sm">Ver</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('faqs.edit', $f) }}" class="btn btn-ghost btn-sm">Editar</a>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-state"><div class="empty-icon">❔</div><div class="empty-text">Nenhuma FAQ cadastrada.</div></div>
    @endforelse
</div>
@endsection
