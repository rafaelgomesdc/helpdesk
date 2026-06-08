@extends('layouts.app')
@section('title', 'Nova Prioridade')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Nova Prioridade</h1>
        <p class="page-subtitle">Cadastre um novo nível de prioridade para os chamados</p>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('prioridades.store') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Nome *</label>
            <input type="text" name="nome" class="form-input"
                   value="{{ old('nome') }}" maxlength="50"
                   placeholder="Ex: Baixa, Média, Alta, Crítica" required>
            @error('nome') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                Nível *
                <span style="font-weight:400; text-transform:none; letter-spacing:0; color:var(--text-muted); font-size:11px;">
                    — 1 = mais baixa, quanto maior o número, maior a urgência
                </span>
            </label>
            <input type="number" name="nivel" class="form-input"
                   value="{{ old('nivel', 1) }}" min="1" max="10" required>
            @error('nivel') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Cor do badge *</label>
            <div style="display:flex; align-items:center; gap:12px;">
                <input type="color" name="cor"
                       value="{{ old('cor', '#6c757d') }}"
                       style="width:48px; height:36px; border-radius:8px; border:1px solid var(--border); background:var(--bg-850); cursor:pointer; padding:2px;">
                <span style="font-size:12px; color:var(--text-muted);">Cor exibida no badge desta prioridade</span>
            </div>
            @error('cor') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar Prioridade</button>
            <a href="{{ route('prioridades.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
