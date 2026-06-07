@extends('layouts.app')
@section('title', 'Abrir Chamado')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Abrir Chamado</h1>
        <p class="page-subtitle">Descreva o problema com o máximo de detalhes</p>
    </div>
</div>

<div class="form-card">
    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-input" value="{{ old('title') }}" required>
            @error('title') <div class="form-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Categoria</label>
                <select name="categoria_id" class="form-select" required>
                    <option value="">Selecione...</option>
                    @foreach($categorias as $c)
                        <option value="{{ $c->id }}" @selected(old('categoria_id')==$c->id)>{{ $c->nome }}</option>
                    @endforeach
                </select>
                @error('categoria_id') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Prioridade</label>
                <select name="priority" class="form-select" required>
                    @foreach($prioridades as $key => $label)
                        <option value="{{ $key }}" @selected(old('priority','medium')==$key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('priority') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-textarea" rows="6" required>{{ old('description') }}</textarea>
            @error('description') <div class="form-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label class="form-label">Anexos (opcional)</label>
            <input type="file" name="anexos[]" class="form-input" multiple>
            @error('anexos.*') <div class="form-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Abrir Chamado</button>
            <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
@endsection
