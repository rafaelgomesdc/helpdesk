@extends('layouts.app')

@section('content')
<div class="dashboard">

    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Visão geral dos chamados</p>
    </div>

    <div class="stats-grid">

        <div class="stat-card card-blue">
            <span class="stat-label">ABERTOS</span>
            <h2>{{ $abertos ?? 0 }}</h2>
            <small>Aguardando atendimento</small>
        </div>

        <div class="stat-card card-yellow">
            <span class="stat-label">EM ATENDIMENTO</span>
            <h2>{{ $atendimento ?? 0 }}</h2>
            <small>Em análise técnica</small>
        </div>

        <div class="stat-card card-green">
            <span class="stat-label">FINALIZADOS</span>
            <h2>{{ $finalizados ?? 0 }}</h2>
            <small>Chamados concluídos</small>
        </div>

        <div class="stat-card card-red">
            <span class="stat-label">TEMPO MÉDIO</span>
            <h2>0h</h2>
            <small>Média de resolução</small>
        </div>

    </div>

    <div class="table-card">
        <h3>Resumo do Sistema</h3>

        <p>
            Utilize o menu lateral para acessar:
        </p>

        <ul>
            <li>Chamados Pendentes</li>
            <li>Chamados em Atendimento</li>
            <li>Histórico de Chamados</li>
        </ul>
    </div>

</div>
@endsection