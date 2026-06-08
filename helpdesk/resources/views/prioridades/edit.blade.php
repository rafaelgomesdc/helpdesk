@extends('layouts.app')
@section('title', 'Editar Prioridade')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Editar Prioridade</h1>
        <p class="page-subtitle">Atualize as informações da prioridade</p>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('prioridades.update', $prioridade) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label class="form-label">Nome *</label>
            <input type="text" name="nome" class="form-input"
                   value="{{ old('nome', $prioridade->nome) }}" maxlength="50" required>
            @error('nome') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nível *
                <span style="font-weight:400; text-transform:none; letter-spacing:0; color:var(--text-muted); font-size:11px;">
                    — 1 = mais baixa, quanto maior o número, maior a urgência
                </span>
            </label>
            <input type="number" name="nivel" class="form-input"
                   value="{{ old('nivel', $prioridade->nivel) }}" min="1" max="10" required>
            @error('nivel') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Cor do badge *</label>
            <div style="display:flex; align-items:center; gap:12px;">
                <input type="color" name="cor" value="{{ old('cor', $prioridade->cor) }}"
                       style="width:48px; height:36px; border-radius:8px; border:1px solid var(--border); background:var(--bg-850); cursor:pointer; padding:2px;">
                <span style="font-size:12px; color:var(--text-muted);">Cor atual do badge desta prioridade</span>
            </div>
            @error('cor') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar Alterações</button>
            <a href="{{ route('prioridades.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
