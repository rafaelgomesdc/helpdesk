@extends('layouts.app')
@section('title', 'Nova FAQ')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Nova FAQ</h1>
        <p class="page-subtitle">Adicione uma nova pergunta e resposta à base de conhecimento</p>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('faqs.store') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Categoria</label>
            <select name="categoria_id" class="form-select">
                <option value="">— Sem categoria —</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nome }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Pergunta *</label>
            <textarea name="pergunta" class="form-textarea" rows="3"
                      required placeholder="Digite a pergunta...">{{ old('pergunta') }}</textarea>
            @error('pergunta') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Resposta *</label>
            <textarea name="resposta" class="form-textarea" rows="7"
                      required placeholder="Digite a resposta completa...">{{ old('resposta') }}</textarea>
            @error('resposta') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar FAQ</button>
            <a href="{{ route('faqs.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
