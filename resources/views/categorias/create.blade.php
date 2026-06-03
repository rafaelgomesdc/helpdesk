@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Nova Categoria</h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('categorias.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control"
                       value="{{ old('nome') }}" required maxlength="100">
                @error('nome') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3"
                          placeholder="Descreva o propósito desta categoria...">{{ old('descricao') }}</textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
