@extends('layouts.app')
@section('title', 'Nova Categoria')
@section('content')

    <h2>Cadastrar Categoria</h2>
    <form action="{{ route('categorias.store') }}" method="POST">
        @include('categorias._form')
        <button type="submit">Salvar</button>
        <a class="button" href="{{ route('categorias.index') }}">Cancelar</a>
    </form>

@endsection@extends('layouts.app')
@section('title', 'Nova Categoria')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Nova Categoria</h1>
        <p class="page-subtitle">Adicione uma nova categoria de chamados ao sistema</p>
    </div>
</div>

<div class="form-card">
    <form action="{{ route('categorias.store') }}" method="POST">
        @include('categorias._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar Categoria</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection