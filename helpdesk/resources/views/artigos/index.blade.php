@extends('layouts.app')
@section('title', 'Base de Conhecimento')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Artigos</h1><p class="page-subtitle">Soluções e documentação</p></div>
    @if(auth()->user()->isAdmin() || auth()->user()->profile === 'Técnico')
        <a href="{{ route('artigos.create') }}" class="btn btn-primary">+ Novo Artigo</a>
    @endif
</div>
<div class="table-wrap">
    <table>
        <thead><tr><th>Título</th><th>Categoria</th><th>Autor</th><th>Ações</th></tr></thead>
        <tbody>
            @forelse($artigos as $a)
            <tr>
                <td style="font-weight:600;color:var(--text-primary);">{{ $a->titulo }}</td>
                <td>{{ $a->categoria?->nome ?? '—' }}</td>
                <td>{{ $a->autor?->name ?? '—' }}</td>
                <td>
                    <a href="{{ route('artigos.show', $a) }}" class="btn btn-ghost btn-sm">Ler</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('artigos.edit', $a) }}" class="btn btn-ghost btn-sm">Editar</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="empty-text">Nenhum artigo publicado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
