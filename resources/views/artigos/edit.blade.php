@extends('layouts.app')
@section('title', 'Editar Artigo')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Editar Artigo</h1>
        <p class="page-subtitle">Atualize o conteúdo do artigo</p>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('artigos.update', $artigo) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Categoria</label>
            <select name="categoria_id" class="form-select">
                <option value="">— Sem categoria —</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('categoria_id', $artigo->categoria_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nome }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Título *</label>
            <input type="text" name="titulo" class="form-input"
                   value="{{ old('titulo', $artigo->titulo) }}" required maxlength="255">
            @error('titulo') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Conteúdo *</label>
            <textarea name="conteudo" class="form-textarea" style="min-height:280px;"
                      required>{{ old('conteudo', $artigo->conteudo) }}</textarea>
            @error('conteudo') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar Alterações</button>
            <a href="{{ route('artigos.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
