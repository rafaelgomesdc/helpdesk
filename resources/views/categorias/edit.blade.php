@extends('layouts.app')
@section('title', 'Editar Categoria')
@section('content')

    <h2>Editar Categoria</h2>
    <form action="{{ route('categorias.update', $categoria) }}" method="POST">
        @csrf
        @method('PUT')
        @include('categorias._form', ['categoria' => $categoria])
        <button type="submit">Atualizar</button>
        <a class="button" href="{{ route('categorias.index') }}">Cancelar</a>
    </form>

@endsection