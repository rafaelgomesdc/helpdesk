@extends('layouts.app')
@section('title', 'Tempo Médio de Atendimento')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Tempo Médio de Atendimento</h1>
        <p class="page-subtitle">Análise do tempo de resolução dos chamados</p>
    </div>
</div>

{{-- Filtros --}}
<div class="form-card" style="max-width:100%; margin-bottom:28px;">
    <form method="GET" action="{{ route('relatorios.tempo-medio') }}"
          style="display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:16px; align-items:end;">

        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Data inicial</label>
            <input type="date" name="de" class="form-input" value="{{ $de }}">
        </div>

        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Data final</label>
            <input type="date" name="ate" class="form-input" value="{{ $ate }}">
        </div>

        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Prioridade</label>
            <select name="prioridade" class="form-select">
                <option value="">Todas</option>
                @foreach($prioridades as $valor => $label)
                    <option value="{{ $valor }}" {{ $prioridade == $valor ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display:flex; gap:8px;">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('relatorios.tempo-medio') }}" class="btn btn-ghost">Limpar</a>
        </div>
    </form>
</div>

@if($geral && $geral->total > 0)

    {{-- Cards de resumo --}}
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-label">Total resolvidos</div>
            <div class="stat-value blue">{{ $geral->total }}</div>
            <div class="stat-footer">Chamados encerrados</div>
        </div>
        <div class="stat-card green">
            <div class="stat-label">Tempo médio</div>
            <div class="stat-value green" style="font-size:28px;">{{ $geral->media_formatada }}</div>
            <div class="stat-footer">Média de resolução</div>
        </div>
        <div class="stat-card amber">
            <div class="stat-label">Menor tempo</div>
            <div class="stat-value amber" style="font-size:28px;">{{ $geral->min_formatado }}</div>
            <div class="stat-footer">Atendimento mais rápido</div>
        </div>
        <div class="stat-card rose">
            <div class="stat-label">Maior tempo</div>
            <div class="stat-value rose">{{ $geral->max_formatado }}</div>
            <div class="stat-footer">Atendimento mais longo</div>
        </div>
    </div>

    {{-- Tabela por prioridade --}}
    @if($porPrioridade->isNotEmpty())
    @php
        $badgePrioridade = [
            'critical' => 'rose',
            'high'     => 'amber',
            'medium'   => 'blue',
            'low'      => 'gray',
        ];
    @endphp
    <div class="table-wrap">
        <div class="table-header">
            <span class="table-title">Tempo médio por prioridade</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Prioridade</th>
                    <th>Chamados resolvidos</th>
                    <th>Tempo médio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($porPrioridade as $linha)
                <tr>
                    <td>
                        <span class="badge badge-{{ $badgePrioridade[$linha->priority] ?? 'gray' }}">
                            {{ $prioridades[$linha->priority] ?? $linha->priority }}
                        </span>
                    </td>
                    <td>{{ $linha->total }}</td>
                    <td style="font-weight:600; color:var(--text-primary);">{{ $linha->media_formatada }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

@else
    <div class="table-wrap">
        <div class="empty-state">
            <div class="empty-icon">📊</div>
            <div class="empty-text">Nenhum chamado resolvido encontrado com os filtros selecionados.</div>
        </div>
    </div>
@endif

@endsection
