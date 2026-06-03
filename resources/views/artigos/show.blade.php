@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Artigo</h2>
    <a href="{{ route('artigos.index') }}" class="btn btn-secondary">Voltar</a>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($artigo->categoria)
            <span class="badge bg-secondary mb-2">{{ $artigo->categoria->nome }}</span>
        @endif

        <h3 class="mb-1">{{ $artigo->titulo }}</h3>
        <small class="text-muted d-block mb-4">
            Por {{ $artigo->autor?->name ?? 'Desconhecido' }}
            &bull; {{ $artigo->created_at->format('d/m/Y H:i') }}
            @if($artigo->updated_at->ne($artigo->created_at))
                &bull; Atualizado em {{ $artigo->updated_at->format('d/m/Y H:i') }}
            @endif
        </small>

        <hr>

        <div style="white-space: pre-wrap; line-height: 1.8;">{{ $artigo->conteudo }}</div>

        @if(session('user_role') == 'admin' || session('user_role') == 'technician')
            <div class="mt-4 border-top pt-3">
                <a href="{{ route('artigos.edit', $artigo) }}" class="btn btn-outline-secondary">Editar</a>
                <form method="POST" action="{{ route('artigos.destroy', $artigo) }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger"
                        onclick="return confirm('Excluir este artigo?')">Excluir</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
