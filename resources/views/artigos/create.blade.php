@extends('layouts.app')
@section('title', 'Novo Artigo')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Novo Artigo</h1>
        <p class="page-subtitle">Publique um novo artigo na base de conhecimento</p>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('artigos.store') }}">
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
            <label class="form-label">Título *</label>
            <input type="text" name="titulo" class="form-input"
                   value="{{ old('titulo') }}" required maxlength="255"
                   placeholder="Título do artigo">
            @error('titulo') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Conteúdo *</label>
            <textarea name="conteudo" class="form-textarea" style="min-height:280px;"
                      required placeholder="Escreva o conteúdo do artigo...">{{ old('conteudo') }}</textarea>
            @error('conteudo') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Publicar Artigo</button>
            <a href="{{ route('artigos.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
