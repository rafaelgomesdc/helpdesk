@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Novo Chamado</h1>
        <p class="page-subtitle">Descreva o seu problema detalhadamente.</p>
    </div>
</div>

<div class="form-card">
    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label" for="title">Título da Solicitação</label>
            <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" required>
            @error('title') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div style="display: flex; gap: 16px;">
            <div class="form-group" style="flex: 1;">
                <label class="form-label" for="categoria_id">Categoria</label>
                <select name="categoria_id" id="categoria_id" class="form-input" required>
                    <option value="">Selecione...</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group" style="flex: 1;">
                <label class="form-label" for="priority">Prioridade</label>
                <select name="priority" id="priority" class="form-input" required>
                    <option value="">Selecione...</option>
                    @foreach($prioridades as $valor => $rotulo)
                        <option value="{{ $valor }}" {{ old('priority') == $valor ? 'selected' : '' }}>
                            {{ $rotulo }}
                        </option>
                    @endforeach
                </select>
                @error('priority') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Descrição do Problema</label>
            <textarea name="description" id="description" class="form-textarea" required>{{ old('description') }}</textarea>
            @error('description') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="anexos">Anexos (Opcional - Máx 10MB)</label>
            <input type="file" name="anexos[]" id="anexos" class="form-input" multiple style="padding: 6px 14px;">
            <div style="font-size: 11px; color: var(--text-muted); margin-top: 5px;">Selecione vários arquivos de uma vez segurando Ctrl.</div>
            @error('anexos.*') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
        </div>
    </form>
</div>
@endsection