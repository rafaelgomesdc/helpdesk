@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Detalhes da FAQ</h2>
    <a href="{{ route('faqs.index') }}" class="btn btn-secondary">Voltar</a>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($faq->categoria)
            <span class="badge bg-secondary mb-3">{{ $faq->categoria->nome }}</span>
        @endif

        <h5 class="fw-bold">Pergunta</h5>
        <p class="mb-4">{{ $faq->pergunta }}</p>

        <h5 class="fw-bold">Resposta</h5>
        <p class="mb-4" style="white-space: pre-wrap;">{{ $faq->resposta }}</p>

        <small class="text-muted">Criado em {{ $faq->created_at->format('d/m/Y H:i') }}</small>

        @if(session('user_role') == 'admin' || session('user_role') == 'technician')
            <div class="mt-4 border-top pt-3">
                <a href="{{ route('faqs.edit', $faq) }}" class="btn btn-outline-secondary">Editar</a>
                <form method="POST" action="{{ route('faqs.destroy', $faq) }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger"
                        onclick="return confirm('Excluir esta FAQ?')">Excluir</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
