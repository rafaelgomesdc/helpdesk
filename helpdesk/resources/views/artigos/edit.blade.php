@extends('layouts.app')
@section('title', 'Editar Artigo')
@section('content')
<div class="page-header"><div><h1 class="page-title">Editar Artigo</h1></div></div>
<div class="form-card"><form action="{{ route('artigos.update', $artigo) }}" method="POST">@csrf @method('PUT') @include('artigos._form', ['artigo'=>$artigo])<div class="form-actions"><button class="btn btn-primary">Atualizar</button><a href="{{ route('artigos.index') }}" class="btn btn-ghost">Cancelar</a></div></form></div>
@endsection
