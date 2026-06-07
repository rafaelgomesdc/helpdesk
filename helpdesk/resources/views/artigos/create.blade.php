@extends('layouts.app')
@section('title', 'Novo Artigo')
@section('content')
<div class="page-header"><div><h1 class="page-title">Novo Artigo</h1></div></div>
<div class="form-card"><form action="{{ route('artigos.store') }}" method="POST">@csrf @include('artigos._form')<div class="form-actions"><button class="btn btn-primary">Publicar</button><a href="{{ route('artigos.index') }}" class="btn btn-ghost">Cancelar</a></div></form></div>
@endsection
