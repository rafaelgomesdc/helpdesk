@extends('layouts.app')
@section('title', $artigo->titulo)
@section('content')
<div class="page-header">
    <div><h1 class="page-title">{{ $artigo->titulo }}</h1><p class="page-subtitle">{{ $artigo->categoria?->nome }} · {{ $artigo->autor?->name }}</p></div>
    <a href="{{ route('artigos.index') }}" class="btn btn-ghost">Voltar</a>
</div>
<div class="form-card" style="max-width:100%;"><div style="line-height:1.7;color:var(--text-secondary);white-space:pre-wrap;">{{ $artigo->conteudo }}</div></div>
@endsection
