@extends('layouts.app')
@section('title', 'Nova Categoria')
@section('content')

<div class="page-header mb-4">
    <div>
        <h1 class="page-title mb-1">Nova Categoria</h1>
        <p class="page-subtitle mb-0 text-secondary">Adicione uma nova categoria de chamados ao sistema</p>
    </div>
</div>

<div class="form-card" style="max-width: 700px;">
    <form action="{{ route('categorias.store') }}" method="POST">
        @include('categorias._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar Categoria</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
