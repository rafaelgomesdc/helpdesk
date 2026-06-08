@extends('layouts.app')
@section('title', 'Nova Categoria')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Nova Categoria</h1>
        <p class="page-subtitle">Adicione uma categoria para organizar FAQs e artigos</p>
    </div>
</div>

<div class="form-card" style="max-width:560px;">
    <form method="POST" action="{{ route('categorias.store') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Nome *</label>
            <input type="text" name="nome" class="form-input"
                   value="{{ old('nome') }}" required maxlength="100"
                   placeholder="Nome da categoria">
            @error('nome') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-textarea" rows="3"
                      placeholder="Descreva o propósito desta categoria...">{{ old('descricao') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar Categoria</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
