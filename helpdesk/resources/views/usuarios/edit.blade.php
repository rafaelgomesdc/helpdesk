@extends('layouts.app')
@section('title', 'Editar Usuário')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Editar Usuário</h1>
        <p class="page-subtitle">{{ $usuario->name }}</p>
    </div>
    <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-ghost">Ver detalhes</a>
</div>

<div class="form-card">
    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf @method('PUT')
        @include('usuarios._form', ['usuario' => $usuario])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Atualizar Usuário</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
