@extends('layouts.app')
@section('title', 'FAQs')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Perguntas Frequentes</h1>
        <p class="page-subtitle">Base de conhecimento — perguntas e respostas</p>
    </div>
    @if(session('user_role') == 'admin' || session('user_role') == 'technician')
        <a href="{{ route('faqs.create') }}" class="btn btn-primary">+ Nova FAQ</a>
    @endif
</div>

<div class="table-wrap">
    <div class="table-header">
        <span class="table-title">{{ $faqs->count() }} FAQ(s) cadastrada(s)</span>
    </div>

    @if($faqs->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">❓</div>
            <div class="empty-text">Nenhuma FAQ cadastrada ainda.</div>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Pergunta</th>
                    <th>Categoria</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faqs as $faq)
                <tr>
                    <td style="color:var(--text-primary); font-weight:500;">
                        {{ Str::limit($faq->pergunta, 80) }}
                    </td>
                    <td>
                        @if($faq->categoria)
                            <span class="badge">{{ $faq->categoria->nome }}</span>
                        @else
                            <span style="color:var(--text-muted);">—</span>
                        @endif
                    </td>
                    <td style="font-family:'IBM Plex Mono',monospace; font-size:11px;">
                        {{ $faq->created_at->format('d/m/Y') }}
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('faqs.show', $faq) }}" class="btn btn-ghost btn-sm">👁 Ver</a>
                            @if(session('user_role') == 'admin' || session('user_role') == 'technician')
                                <a href="{{ route('faqs.edit', $faq) }}" class="btn btn-ghost btn-sm">✏️ Editar</a>
                                <form method="POST" action="{{ route('faqs.destroy', $faq) }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Excluir esta FAQ?')">🗑 Excluir</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
