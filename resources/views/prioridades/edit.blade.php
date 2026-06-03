@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Editar Prioridade</h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('prioridades.update', $prioridade) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nome <span class="text-danger">*</span></label>
                <input type="text"
                       name="nome"
                       class="form-control @error('nome') is-invalid @enderror"
                       value="{{ old('nome', $prioridade->nome) }}"
                       maxlength="50"
                       required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Nível <span class="text-danger">*</span>
                    <small class="text-muted">(1 = mais baixa, quanto maior o número, maior a urgência)</small>
                </label>
                <input type="number"
                       name="nivel"
                       class="form-control @error('nivel') is-invalid @enderror"
                       value="{{ old('nivel', $prioridade->nivel) }}"
                       min="1"
                       max="10"
                       required>
                @error('nivel')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Cor do badge <span class="text-danger">*</span></label>
                <div class="d-flex align-items-center gap-3">
                    <input type="color"
                           name="cor"
                           class="form-control form-control-color @error('cor') is-invalid @enderror"
                           value="{{ old('cor', $prioridade->cor) }}"
                           title="Escolha a cor"
                           required>
                    <span class="text-muted">Cor atual do badge desta prioridade.</span>
                </div>
                @error('cor')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="{{ route('prioridades.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
