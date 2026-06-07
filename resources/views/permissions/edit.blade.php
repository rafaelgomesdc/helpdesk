@extends('layouts.app')
@section('title', 'Editar Permissão')
@section('content')
<div class="page-header"><div><h1 class="page-title">Editar Permissão</h1><p class="page-subtitle">{{ $permission->name }}</p></div></div>
<div class="form-card">
    <form action="{{ route('permissions.update', $permission) }}" method="POST">
        @csrf @method('PUT')
        @include('permissions._form', ['permission' => $permission])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('permissions.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
@endsection
