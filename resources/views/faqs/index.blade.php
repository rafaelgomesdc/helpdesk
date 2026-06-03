@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Perguntas Frequentes (FAQs)</h2>
    @if(session('user_role') == 'admin' || session('user_role') == 'technician')
        <a href="{{ route('faqs.create') }}" class="btn btn-primary">+ Nova FAQ</a>
    @endif
</div>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Pergunta</th>
                    <th>Categoria</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                <tr>
                    <td>{{ Str::limit($faq->pergunta, 80) }}</td>
                    <td>{{ $faq->categoria?->nome ?? '-' }}</td>
                    <td>{{ $faq->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('faqs.show', $faq) }}" class="btn btn-sm btn-outline-info">Ver</a>
                        @if(session('user_role') == 'admin' || session('user_role') == 'technician')
                            <a href="{{ route('faqs.edit', $faq) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form method="POST" action="{{ route('faqs.destroy', $faq) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Excluir esta FAQ?')">Excluir</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Nenhuma FAQ cadastrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
