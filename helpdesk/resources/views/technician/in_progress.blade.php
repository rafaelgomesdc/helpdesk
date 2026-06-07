@extends('layouts.app')
@section('title', 'Em Atendimento')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Em Atendimento</h1><p class="page-subtitle">Chamados em tratamento técnico</p></div>
</div>
@include('technician._table', ['tickets' => $tickets, 'action' => 'solution'])
@endsection
