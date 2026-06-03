@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Editar Artigo</h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('artigos.update', $artigo) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select name="categoria_id" class="form-select">
                    <option value="">— Sem categoria —</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('categoria_id', $artigo->categoria_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nome }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control"
                       value="{{ old('titulo', $artigo->titulo) }}" required maxlength="255">
                @error('titulo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Conteúdo</label>
                <textarea name="conteudo" class="form-control" rows="15"
                          required>{{ old('conteudo', $artigo->conteudo) }}</textarea>
                @error('conteudo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="{{ route('artigos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
