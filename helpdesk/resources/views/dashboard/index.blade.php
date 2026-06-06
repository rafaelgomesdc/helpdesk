@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Visão geral dos chamados em tempo real</p>
    </div>
</div>

<<<<<<< HEAD
{{-- CARDS DE TOTAIS --}}
=======
>>>>>>> UsuariosVitoria
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-label">Abertos</div>
        <div class="stat-value blue">{{ $totalAbertos }}</div>
        <div class="stat-footer">Aguardando atendimento</div>
    </div>
    <div class="stat-card amber">
        <div class="stat-label">Em Andamento</div>
        <div class="stat-value amber">{{ $totalAndamento }}</div>
        <div class="stat-footer">Em tratamento técnico</div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Finalizados</div>
        <div class="stat-value green">{{ $totalFinalizados }}</div>
        <div class="stat-footer">Chamados encerrados</div>
    </div>
    <div class="stat-card rose">
        <div class="stat-label">Tempo Médio</div>
        <div class="stat-value rose">{{ $tempoMedio }}h</div>
        <div class="stat-footer">Média de resolução</div>
    </div>
</div>

<<<<<<< HEAD
{{-- CHAMADOS POR CATEGORIA --}}
=======
>>>>>>> UsuariosVitoria
<div class="table-wrap">
    <div class="table-header">
        <span class="table-title">Chamados por Categoria</span>
        <a href="{{ route('categorias.index') }}" class="btn btn-ghost btn-sm">
            Gerenciar Categorias →
        </a>
    </div>

    @php $total = $porCategoria->sum('total') ?: 1; @endphp

    <div style="padding: 20px;">
        @forelse($porCategoria as $cat)
            <div class="progress-wrap">
                <div class="progress-top">
                    <span class="progress-name">{{ $cat->nome }}</span>
                    <span class="progress-count">{{ $cat->total }} chamado{{ $cat->total != 1 ? 's' : '' }}</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ ($cat->total / $total) * 100 }}%"></div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <div class="empty-text">Nenhum chamado registrado ainda</div>
            </div>
        @endforelse
    </div>
</div>

<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> UsuariosVitoria
