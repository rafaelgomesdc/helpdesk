@extends('layouts.app')
@section('title', 'Editar Categoria')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Editar Categoria</h1>
        <p class="page-subtitle">Atualize as informações da categoria</p>
    </div>
</div>

<div class="form-card" style="max-width:560px;">
    <form method="POST" action="{{ route('categorias.update', $categoria) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nome *</label>
            <input type="text" name="nome" class="form-input"
                   value="{{ old('nome', $categoria->nome) }}" required maxlength="100">
            @error('nome') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-textarea" rows="3">{{ old('descricao', $categoria->descricao) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar Alterações</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
