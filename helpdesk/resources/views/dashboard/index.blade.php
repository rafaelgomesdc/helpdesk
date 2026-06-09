@extends('layouts.app')
@section('title', 'Painel de Controle')

@section('content')

@php
    $categoriaLabels = $porCategoria->map(fn($item) => $item->categoria?->nome ?? 'Sem categoria')->values();
    $categoriaData = $porCategoria->pluck('total')->values();

    $prioridadeLabels = $byPriority->map(function ($item) {
        return [
            'low' => 'Baixa',
            'medium' => 'Média',
            'high' => 'Alta',
            'critical' => 'Crítica'
        ][$item->priority] ?? $item->priority;
    })->values();

    $prioridadeData = $byPriority->pluck('total')->values();
@endphp

<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Painel de Controle</h1>
        <p class="page-subtitle mb-0">Visão geral dos chamados e atividades do sistema</p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('dashboard.export-csv') }}" class="btn btn-ghost">
            Exportar
        </a>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                Novo Chamado
            </a>
        @endif
    </div>
</div>

<ul class="nav nav-tabs dashboard-tabs mb-4" id="dashboardTabs" role="tablist">
    <li class="nav-item-tab" role="presentation">
        <button class="dash-tab active" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats-pane" type="button" role="tab" aria-controls="stats-pane" aria-selected="true">
            Indicadores
        </button>
    </li>

    <li class="nav-item-tab" role="presentation">
        <button class="dash-tab" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-pane" type="button" role="tab" aria-controls="profile-pane" aria-selected="false">
            Meu Perfil
        </button>
    </li>

    <li class="nav-item-tab" role="presentation">
        <button class="dash-tab" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity-pane" type="button" role="tab" aria-controls="activity-pane" aria-selected="false">
            Atividades
        </button>
    </li>
</ul>

<div class="tab-content" id="dashboardTabsContent">

    {{-- INDICADORES --}}
    <div class="tab-pane fade show active" id="stats-pane" role="tabpanel" aria-labelledby="stats-tab" tabindex="0">

        <div class="stats-grid mb-4">
            <div class="stat-card dash-card">
                <div class="stat-label">Abertos</div>
                <div class="stat-value">{{ $totalAbertos }}</div>
                <div class="stat-footer">Aguardando atendimento</div>
            </div>

            <div class="stat-card dash-card">
                <div class="stat-label">Em andamento</div>
                <div class="stat-value">{{ $totalAndamento }}</div>
                <div class="stat-footer">Em tratamento técnico</div>
            </div>

            <div class="stat-card dash-card">
                <div class="stat-label">Finalizados</div>
                <div class="stat-value">{{ $totalFinalizados }}</div>
                <div class="stat-footer">Chamados encerrados</div>
            </div>

            <div class="stat-card dash-card">
                <div class="stat-label">Tempo médio</div>
                <div class="stat-value">{{ $tempoMedio }}h</div>
                <div class="stat-footer">Média de resolução</div>
            </div>

            <div class="stat-card dash-card">
                <div class="stat-label">Usuários</div>
                <div class="stat-value">{{ $totalUsuarios ?? 0 }}</div>
                <div class="stat-footer">Colaboradores ativos</div>
            </div>

            <div class="stat-card dash-card">
                <div class="stat-label">Artigos</div>
                <div class="stat-value">{{ $totalArtigos ?? 0 }}</div>
                <div class="stat-footer">Base de conhecimento</div>
            </div>
        </div>

        {{-- GRÁFICOS --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="table-wrap chart-panel">
                    <div class="table-header">
                        <span class="table-title">Status dos chamados</span>
                    </div>

                    <div class="chart-box">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="table-wrap chart-panel">
                    <div class="table-header">
                        <span class="table-title">Chamados por categoria</span>
                    </div>

                    <div class="chart-box">
                        <canvas id="categoriaChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="table-wrap chart-panel">
                    <div class="table-header">
                        <span class="table-title">Chamados por prioridade</span>
                    </div>

                    <div class="chart-box">
                        <canvas id="prioridadeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            {{-- CATEGORIAS --}}
            <div class="col-lg-7">
                <div class="table-wrap h-100 dash-panel">
                    <div class="table-header d-flex justify-content-between align-items-center">
                        <span class="table-title">Chamados por categoria</span>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('categorias.index') }}" class="btn btn-ghost btn-sm">
                                Categorias
                            </a>
                        @endif
                    </div>

                    <div class="dash-panel-body">
                        @php $totalCatSum = $porCategoria->sum('total') ?: 1; @endphp

                        @forelse($porCategoria as $cat)
                            @php
                                $percentualCategoria = ($cat->total / $totalCatSum) * 100;
                            @endphp

                            <div class="progress-wrap">
                                <div class="progress-top">
                                    <span class="progress-name">{{ $cat->categoria?->nome ?? 'Sem Categoria' }}</span>
                                    <span class="progress-count">{{ $cat->total }} chamado{{ $cat->total != 1 ? 's' : '' }}</span>
                                </div>

                                <div class="progress-line">
                                    <div class="progress-fill" style="width: {{ $percentualCategoria }}%;"></div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">—</div>
                                <div class="empty-text">Nenhum chamado categorizado no sistema.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- PRIORIDADES --}}
            <div class="col-lg-5">
                <div class="table-wrap h-100 dash-panel">
                    <div class="table-header">
                        <span class="table-title">Chamados por prioridade</span>
                    </div>

                    <div class="dash-panel-body">
                        @php
                            $prioritiesMap = [
                                'low' => 'Baixa',
                                'medium' => 'Média',
                                'high' => 'Alta',
                                'critical' => 'Crítica'
                            ];

                            $totalPrioritiesSum = $byPriority->sum('total') ?: 1;
                        @endphp

                        @forelse($byPriority as $prio)
                            @php
                                $label = $prioritiesMap[$prio->priority] ?? $prio->priority;
                                $percentualPrioridade = round(($prio->total / $totalPrioritiesSum) * 100);
                            @endphp

                            <div class="priority-row">
                                <div class="priority-left">
                                    <span class="priority-dot"></span>
                                    <span class="priority-name">{{ $label }}</span>
                                </div>

                                <div class="priority-right">
                                    <span class="badge">{{ $prio->total }} chamado{{ $prio->total != 1 ? 's' : '' }}</span>
                                    <span class="priority-percent">{{ $percentualPrioridade }}%</span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">—</div>
                                <div class="empty-text">Nenhum chamado com prioridade definida.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MEU PERFIL --}}
    <div class="tab-pane fade" id="profile-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

        <div class="row g-4">
            <div class="col-12">
                <div class="form-card profile-card">
                    <div class="row align-items-center">
                        <div class="col-md-auto text-center mb-4 mb-md-0">
                            <div class="profile-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>

                        <div class="col-md mb-4 mb-md-0">
                            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                <h3 class="profile-name">{{ $user->name }}</h3>
                                <span class="badge">{{ $user->profile }}</span>
                                <span class="badge">{{ $user->status }}</span>
                            </div>

                            <p class="profile-email">{{ $user->email }}</p>
                        </div>

                        <div class="col-md-auto">
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn btn-ghost">
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INFORMAÇÕES PROFISSIONAIS --}}
            <div class="col-md-6">
                <div class="form-card profile-info-card">
                    <h5 class="section-title">Informações profissionais</h5>

                    <div class="info-block">
                        <label class="form-label">Setor</label>
                        <p>{{ $user->setor?->nome ?? 'Não informado' }}</p>
                    </div>

                    <div class="info-block">
                        <label class="form-label">Cargo / Função</label>
                        <p>{{ $user->cargo?->nome ?? 'Não informado' }}</p>
                    </div>

                    <div class="info-block">
                        <label class="form-label">Telefone / Ramal</label>
                        <p>{{ $user->phone ?? '—' }}</p>
                    </div>

                    <div class="info-block mb-0">
                        <label class="form-label">Endereço corporativo</label>
                        <p>{{ $user->address ?? 'Não informado' }}</p>
                    </div>
                </div>
            </div>

            {{-- INFORMAÇÕES DO SISTEMA --}}
            <div class="col-md-6">
                <div class="form-card profile-info-card">
                    <h5 class="section-title">Informações do sistema</h5>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="mini-card">
                                <div class="mini-label">Perfil</div>
                                <div class="mini-value">{{ $user->profile }}</div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mini-card">
                                <div class="mini-label">Status</div>
                                <div class="mini-value">{{ $user->status }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="system-id">
                        <span>ID do sistema</span>
                        <strong>{{ $user->id }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ATIVIDADES --}}
    <div class="tab-pane fade" id="activity-pane" role="tabpanel" aria-labelledby="activity-tab" tabindex="0">

        <div class="table-wrap">
            <div class="table-header">
                <span class="table-title">Últimas ações registradas</span>
            </div>

            <div class="dash-panel-body">
                @forelse($recentActivities as $act)
                    <div class="activity-row">
                        <div class="activity-icon">
                            @if(str_contains(strtolower($act->action), 'aberto') || str_contains(strtolower($act->action), 'criado'))
                                +
                            @elseif(str_contains(strtolower($act->action), 'atribuído') || str_contains(strtolower($act->action), 'assumiu'))
                                U
                            @elseif(str_contains(strtolower($act->action), 'resolvido') || str_contains(strtolower($act->action), 'solução'))
                                ✓
                            @elseif(str_contains(strtolower($act->action), 'comentário'))
                                C
                            @else
                                •
                            @endif
                        </div>

                        <div class="activity-content">
                            <div class="activity-head">
                                <div>
                                    <h6>{{ $act->action }}</h6>

                                    <p>
                                        No chamado:
                                        <a href="{{ route('tickets.show', $act->ticket_id) }}">
                                            #{{ $act->ticket_id }} — {{ $act->ticket?->title }}
                                        </a>
                                    </p>
                                </div>

                                <span>{{ $act->created_at?->format('d/m/Y H:i') }}</span>
                            </div>

                            <p class="activity-description">
                                {{ $act->description }} — <strong>{{ $act->user?->name ?? 'Sistema' }}</strong>
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">—</div>
                        <div class="empty-text">Nenhuma atividade registrada no histórico recente.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('head')
<style>
    .dashboard-tabs {
        border-bottom: 1px solid var(--border) !important;
        gap: 4px;
    }

    .nav-item-tab {
        margin-bottom: -1px;
    }

    .dash-tab {
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        color: var(--text-muted);
        padding: 9px 14px;
        font-size: 12px;
        font-weight: 650;
        transition: 0.15s ease;
    }

    .dash-tab:hover {
        color: var(--text-primary);
        background: rgba(37, 99, 235, 0.06);
    }

    .dash-tab.active {
        color: var(--text-primary);
        border-bottom-color: var(--accent);
    }

    .dash-card {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(13, 15, 20, 1));
        border-color: rgba(59, 130, 246, 0.18);
    }

    .chart-panel {
        height: 100%;
        border-color: rgba(59, 130, 246, 0.16);
    }

    .chart-box {
        height: 225px;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chart-box canvas {
        width: 100% !important;
        height: 100% !important;
        max-width: 100%;
        max-height: 100%;
    }

    .dash-panel {
        border-color: rgba(59, 130, 246, 0.16);
    }

    .dash-panel-body {
        padding: 18px;
    }

    .progress-wrap {
        margin-bottom: 15px;
    }

    .progress-wrap:last-child {
        margin-bottom: 0;
    }

    .progress-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 7px;
    }

    .progress-name {
        color: var(--text-secondary);
        font-size: 12px;
        font-weight: 500;
    }

    .progress-count {
        color: var(--text-muted);
        font-size: 11px;
        font-weight: 600;
    }

    .progress-line {
        width: 100%;
        height: 6px;
        background: rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(59, 130, 246, 0.08);
        border-radius: 999px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, rgba(37, 99, 235, 0.75), rgba(96, 165, 250, 0.9));
        border-radius: 999px;
        box-shadow: 0 0 10px rgba(37, 99, 235, 0.28);
    }

    .priority-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 10px;
        background: rgba(37, 99, 235, 0.06);
        border: 1px solid rgba(59, 130, 246, 0.12);
    }

    .priority-row:last-child {
        margin-bottom: 0;
    }

    .priority-left,
    .priority-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .priority-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: var(--accent-hover);
        box-shadow: 0 0 8px rgba(59, 130, 246, 0.45);
    }

    .priority-name {
        color: var(--text-secondary);
        font-size: 12px;
        font-weight: 600;
    }

    .priority-percent {
        color: var(--text-muted);
        font-size: 11px;
        font-weight: 650;
        min-width: 34px;
        text-align: right;
    }

    .profile-card {
        max-width: 100%;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.07), rgba(13, 15, 20, 1));
    }

    .profile-avatar {
        width: 66px;
        height: 66px;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.16);
        border: 1px solid rgba(59, 130, 246, 0.28);
        color: var(--text-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        font-weight: 800;
        box-shadow: 0 0 20px rgba(37, 99, 235, 0.10);
    }

    .profile-name {
        color: var(--text-primary);
        margin: 0;
        font-size: 19px;
        font-weight: 720;
    }

    .profile-email {
        color: var(--text-muted);
        margin: 0;
        font-size: 13px;
    }

    .profile-info-card {
        max-width: 100%;
    }

    .section-title {
        color: var(--text-primary);
        font-size: 14px;
        font-weight: 700;
        border-left: 2px solid var(--accent);
        padding-left: 10px;
        margin-bottom: 20px;
    }

    .info-block {
        margin-bottom: 18px;
    }

    .info-block p {
        color: var(--text-secondary);
        font-size: 13px;
        font-weight: 500;
        margin: 0;
    }

    .mini-card {
        padding: 13px;
        border-radius: 11px;
        background: rgba(37, 99, 235, 0.07);
        border: 1px solid rgba(59, 130, 246, 0.12);
    }

    .mini-label {
        color: var(--text-muted);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.45px;
        margin-bottom: 4px;
    }

    .mini-value {
        color: var(--text-primary);
        font-size: 16px;
        font-weight: 700;
    }

    .system-id {
        margin-top: 18px;
        padding: 12px;
        border-radius: 11px;
        background: rgba(37, 99, 235, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.10);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .system-id span {
        color: var(--text-muted);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.45px;
    }

    .system-id strong {
        color: var(--text-secondary);
        font-size: 13px;
    }

    .activity-row {
        display: flex;
        gap: 12px;
        padding-bottom: 14px;
        margin-bottom: 14px;
        border-bottom: 1px solid var(--border-soft);
    }

    .activity-row:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .activity-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: rgba(37, 99, 235, 0.10);
        border: 1px solid rgba(59, 130, 246, 0.18);
        color: var(--accent-hover);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 12px;
        font-weight: 800;
    }

    .activity-content {
        flex: 1;
        min-width: 0;
    }

    .activity-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
    }

    .activity-head h6 {
        color: var(--text-primary);
        margin-bottom: 4px;
        font-size: 12px;
        font-weight: 700;
    }

    .activity-head p {
        margin: 0;
        color: var(--text-muted);
        font-size: 11px;
    }

    .activity-head a {
        color: var(--accent-hover);
        font-weight: 600;
    }

    .activity-head span {
        color: var(--text-muted);
        font-size: 10px;
        white-space: nowrap;
    }

    .activity-description {
        color: var(--text-secondary);
        margin: 6px 0 0;
        font-size: 12px;
    }

    .activity-description strong {
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 14px;
        }

        .dashboard-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .dash-tab {
            white-space: nowrap;
        }

        .activity-head {
            flex-direction: column;
            gap: 4px;
        }

        .chart-box {
            height: 210px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggerTabList = document.querySelectorAll('#dashboardTabs button');

        triggerTabList.forEach(triggerEl => {
            triggerEl.addEventListener('show.bs.tab', event => {
                triggerTabList.forEach(btn => {
                    btn.classList.remove('active');
                });

                event.target.classList.add('active');
            });
        });

        const bluePalette = [
            'rgba(37, 99, 235, 0.86)',
            'rgba(59, 130, 246, 0.74)',
            'rgba(96, 165, 250, 0.62)',
            'rgba(147, 197, 253, 0.50)',
            'rgba(29, 78, 216, 0.70)',
            'rgba(30, 64, 175, 0.66)'
        ];

        const borderBlue = 'rgba(96, 165, 250, 1)';
        const gridBlue = 'rgba(59, 130, 246, 0.10)';
        const textBlue = '#a9c8f5';

        Chart.defaults.color = textBlue;
        Chart.defaults.borderColor = gridBlue;
        Chart.defaults.font.family = 'Inter, sans-serif';

        const statusCanvas = document.getElementById('statusChart');
        const categoriaCanvas = document.getElementById('categoriaChart');
        const prioridadeCanvas = document.getElementById('prioridadeChart');

        if (statusCanvas) {
            new Chart(statusCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Abertos', 'Em andamento', 'Finalizados'],
                    datasets: [{
                        data: [
                            {{ $totalAbertos }},
                            {{ $totalAndamento }},
                            {{ $totalFinalizados }}
                        ],
                        backgroundColor: bluePalette,
                        borderColor: 'rgba(5, 6, 8, 1)',
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                boxHeight: 10,
                                padding: 14,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }

        if (categoriaCanvas) {
            new Chart(categoriaCanvas, {
                type: 'bar',
                data: {
                    labels: @json($categoriaLabels),
                    datasets: [{
                        label: 'Chamados',
                        data: @json($categoriaData),
                        backgroundColor: 'rgba(37, 99, 235, 0.62)',
                        borderColor: borderBlue,
                        borderWidth: 1,
                        borderRadius: 7,
                        maxBarThickness: 34
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    size: 10
                                }
                            },
                            grid: {
                                color: gridBlue
                            }
                        }
                    }
                }
            });
        }

        if (prioridadeCanvas) {
            new Chart(prioridadeCanvas, {
                type: 'bar',
                data: {
                    labels: @json($prioridadeLabels),
                    datasets: [{
                        label: 'Chamados',
                        data: @json($prioridadeData),
                        backgroundColor: 'rgba(59, 130, 246, 0.58)',
                        borderColor: borderBlue,
                        borderWidth: 1,
                        borderRadius: 7,
                        maxBarThickness: 28
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    size: 10
                                }
                            },
                            grid: {
                                color: gridBlue
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush