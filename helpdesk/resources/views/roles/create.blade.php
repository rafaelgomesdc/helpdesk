@extends('layouts.app')
@section('title', 'Novo Perfil')
@section('content')

<div class="page-header"><div><h1 class="page-title">Novo Perfil</h1></div></div>

<div class="form-card">
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        @include('roles._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar Perfil</button>
            <a href="{{ route('roles.index') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
@endsection
