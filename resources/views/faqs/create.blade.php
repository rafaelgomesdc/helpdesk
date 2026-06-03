@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Nova FAQ</h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('faqs.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select name="categoria_id" class="form-select">
                    <option value="">— Sem categoria —</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nome }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Pergunta</label>
                <textarea name="pergunta" class="form-control" rows="3"
                          required placeholder="Digite a pergunta...">{{ old('pergunta') }}</textarea>
                @error('pergunta') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Resposta</label>
                <textarea name="resposta" class="form-control" rows="6"
                          required placeholder="Digite a resposta completa...">{{ old('resposta') }}</textarea>
                @error('resposta') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('faqs.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
