@extends('layouts.app')
@section('title', 'Editar Categoria')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Editar Categoria</h1>
        <p class="page-subtitle">Atualizando: <strong style="color:var(--blue-400)">{{ $categoria->nome }}</strong></p>
    </div>
</div>

<div class="form-card">
    <form action="{{ route('categorias.update', $categoria) }}" method="POST">
        @csrf
        @method('PUT')
        @include('categorias._form', ['categoria' => $categoria])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Atualizar Categoria</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
