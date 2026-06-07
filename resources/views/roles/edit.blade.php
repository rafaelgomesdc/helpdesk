@extends('layouts.app')
@section('title', 'Editar Perfil')
@section('content')

<div class="page-header"><div><h1 class="page-title">Editar Perfil</h1><p class="page-subtitle">{{ $role->name }}</p></div></div>

<div class="form-card">
    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf @method('PUT')
        @include('roles._form', ['role' => $role])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
            <a href="{{ route('roles.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
@endsection
