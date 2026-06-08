@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Relatório: Tempo Médio de Atendimento</h2>
</div>

{{-- Filtros --}}
<div class="card shadow mb-4">
    <div class="card-header bg-light fw-semibold">Filtros</div>
    <div class="card-body">
        <form method="GET" action="{{ route('relatorios.tempo-medio') }}" class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="form-label">Data inicial</label>
                <input type="date" name="de" class="form-control" value="{{ $de }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Data final</label>
                <input type="date" name="ate" class="form-control" value="{{ $ate }}">
            </div>

            <div class="col-md-3">
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

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                <a href="{{ route('relatorios.tempo-medio') }}" class="btn btn-secondary w-100">Limpar</a>
            </div>

        </form>
    </div>
</div>

@if($geral && $geral->total > 0)

    {{-- Cards de resumo --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card text-center shadow-sm border-primary">
                <div class="card-body">
                    <div class="fs-1 fw-bold text-primary">{{ $geral->total }}</div>
                    <div class="text-muted">Chamados resolvidos</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm border-success">
                <div class="card-body">
                    <div class="fs-1 fw-bold text-success">{{ $geral->media_formatada }}</div>
                    <div class="text-muted">Tempo médio</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm border-info">
                <div class="card-body">
                    <div class="fs-1 fw-bold text-info">{{ $geral->min_formatado }}</div>
                    <div class="text-muted">Menor tempo</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm border-danger">
                <div class="card-body">
                    <div class="fs-1 fw-bold text-danger">{{ $geral->max_formatado }}</div>
                    <div class="text-muted">Maior tempo</div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabela por prioridade --}}
    @if($porPrioridade->isNotEmpty())
    <div class="card shadow">
        <div class="card-header bg-light fw-semibold">Tempo médio por prioridade</div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Prioridade</th>
                        <th class="text-center">Chamados resolvidos</th>
                        <th class="text-center">Tempo médio</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $badges = [
                            'critical' => 'danger',
                            'high'     => 'warning',
                            'medium'   => 'primary',
                            'low'      => 'secondary',
                        ];
                    @endphp
                    @foreach($porPrioridade as $linha)
                    <tr>
                        <td>
                            <span class="badge bg-{{ $badges[$linha->priority] ?? 'secondary' }}">
                                {{ $prioridades[$linha->priority] ?? $linha->priority }}
                            </span>
                        </td>
                        <td class="text-center">{{ $linha->total }}</td>
                        <td class="text-center fw-semibold">{{ $linha->media_formatada }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

@else
    <div class="alert alert-info">
        Nenhum chamado resolvido encontrado com os filtros selecionados.
    </div>
@endif

@endsection
