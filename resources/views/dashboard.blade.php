@extends('layouts.app')
@section('title', 'Painel Principal')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Bem-vindo(a), {{ Session::get('usuario_nome') }}!</h1>

    <div class="alert alert-info">
        Perfil: <strong>{{ Session::get('usuario_perfil') }}</strong>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <a href="{{ route('setores.index') }}" class="btn btn-primary w-100 py-3">
                Gerenciar Setores
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('cargos.index') }}" class="btn btn-success w-100 py-3">
                Gerenciar Cargos
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('usuarios.index') }}" class="btn btn-warning w-100 py-3">
                Gerenciar Usuários
            </a>
        </div>
    </div>
</div>
@endsection