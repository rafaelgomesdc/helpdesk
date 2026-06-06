@extends('layouts.app')
@section('title', 'Novo Usuário')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Novo Usuário</h1>
        <p class="page-subtitle">Cadastre um colaborador no sistema</p>
    </div>
</div>

<div class="form-card">
    <form action="{{ route('usuarios.store') }}" method="POST">
        @include('usuarios._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar Usuário</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
