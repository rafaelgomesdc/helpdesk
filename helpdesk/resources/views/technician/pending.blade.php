@extends('layouts.app')
@section('title', 'Chamados Pendentes')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Chamados Pendentes</h1><p class="page-subtitle">Aguardando atribuição de técnico</p></div>
</div>
@include('technician._table', ['tickets' => $tickets, 'action' => 'assign'])
@endsection
