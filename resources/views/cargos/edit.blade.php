@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Editar Cargo</h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('cargos.update', $cargo) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nome do Cargo</label>
                <input type="text" 
                       name="nome" 
                       class="form-control" 
                       value="{{ old('nome', $cargo->nome) }}" 
                       required>
                @error('nome') 
                    <small class="text-danger">{{ $message }}</small> 
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" 
                          class="form-control" 
                          rows="4" 
                          placeholder="Descreva as responsabilidades ou atribuições deste cargo...">{{ old('descricao', $cargo->descricao) }}</textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="{{ route('cargos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection