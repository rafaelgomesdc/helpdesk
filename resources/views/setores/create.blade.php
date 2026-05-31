@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Cadastrar Novo Setor</h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('setores.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nome do Setor</label>
                <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
                @error('nome') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="4" placeholder="Descreva as atividades ou responsabilidades do setor...">{{ old('descricao') }}</textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('setores.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection