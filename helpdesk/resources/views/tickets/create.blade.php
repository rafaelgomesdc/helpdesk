@extends('layouts.app')
@section('title', 'Abrir Chamado')

@section('content')

<style>
    .create-page {
        max-width: 780px;
        margin: 0 auto;
    }

    .create-header {
        margin-bottom: 18px;
    }

    .create-card {
        background: linear-gradient(180deg, rgba(37, 99, 235, 0.035), var(--bg-card) 38%);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 0;
        overflow: hidden;
    }

    .create-card-top {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        background: rgba(37, 99, 235, 0.035);
    }

    .create-card-title {
        color: var(--text-primary);
        font-size: 14px;
        font-weight: 750;
        margin: 0 0 4px;
    }

    .create-card-subtitle {
        color: var(--text-muted);
        font-size: 11.5px;
        margin: 0;
    }

    .create-card-body {
        padding: 24px;
    }

    .create-section {
        margin-bottom: 17px;
    }

    .create-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 17px;
    }

    .create-card .form-label {
        font-size: 11px;
        margin-bottom: 6px;
        color: var(--text-secondary);
    }

    .create-card .form-input,
    .create-card .form-select,
    .create-card .form-textarea {
        font-size: 13px;
        border-radius: 10px;
        background: rgba(5, 6, 8, 0.72);
    }

    .create-card .form-input:focus,
    .create-card .form-select:focus,
    .create-card .form-textarea:focus {
        background: rgba(5, 6, 8, 0.95);
    }

    .create-card .form-textarea {
        min-height: 135px;
        resize: vertical;
        line-height: 1.5;
    }

    .file-simple {
        padding: 8px 10px;
        font-size: 12px;
        cursor: pointer;
    }

    .file-simple::file-selector-button {
        background: rgba(37, 99, 235, 0.14);
        border: 1px solid var(--border);
        color: var(--text-primary);
        border-radius: 8px;
        padding: 6px 11px;
        margin-right: 10px;
        font-size: 11px;
        font-weight: 650;
        cursor: pointer;
        transition: 0.15s ease;
    }

    .file-simple::file-selector-button:hover {
        background: rgba(37, 99, 235, 0.24);
        border-color: var(--accent);
    }

    .file-help {
        color: var(--text-muted);
        font-size: 10.5px;
        margin-top: 6px;
        line-height: 1.4;
    }

    .create-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid var(--border);
    }

    .create-actions .btn {
        min-width: 118px;
    }

    @media (max-width: 768px) {
        .create-page {
            max-width: 100%;
        }

        .create-card-top,
        .create-card-body {
            padding: 18px;
        }

        .create-grid {
            grid-template-columns: 1fr;
        }

        .create-actions {
            flex-direction: column-reverse;
        }

        .create-actions .btn {
            width: 100%;
        }
    }
</style>

<div class="create-page">


<div class="page-header create-header">
    <div>
        <h1 class="page-title">Abrir Chamado</h1>
        <p class="page-subtitle">
            Registre uma solicitação para análise do suporte.
        </p>
    </div>
</div>

<div class="create-card">
    <div class="create-card-top">
        <h2 class="create-card-title">Dados do chamado</h2>
        <p class="create-card-subtitle">
            Preencha as informações principais do problema.
        </p>
    </div>

    <div class="create-card-body">
        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group create-section">
                <label class="form-label">Título do chamado</label>

                <input
                    type="text"
                    name="title"
                    class="form-input"
                    value="{{ old('title') }}"
                    placeholder="Ex: Monitor sem sinal"
                    required
                >

                @error('title')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="create-grid">
                <div class="form-group mb-0">
                    <label class="form-label">Categoria</label>

                    <select name="categoria_id" class="form-select" required>
                        <option value="">Selecione uma categoria</option>

                        @foreach($categorias as $c)
                            <option value="{{ $c->id }}" @selected(old('categoria_id') == $c->id)>
                                {{ $c->nome }}
                            </option>
                        @endforeach
                    </select>

                    @error('categoria_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Prioridade</label>

                    <select name="priority" class="form-select" required>
                        @php
                            $prioLabels = [
                                'low' => 'Baixa',
                                'medium' => 'Média',
                                'high' => 'Alta',
                                'critical' => 'Crítica'
                            ];
                        @endphp

                        @foreach($prioridades as $key => $label)
                            <option value="{{ $key }}" @selected(old('priority', 'medium') == $key)>
                                {{ $prioLabels[$key] ?? $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('priority')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group create-section">
                <label class="form-label">Descrição do problema</label>

                <textarea
                    name="description"
                    class="form-textarea"
                    rows="6"
                    placeholder="Explique o que está acontecendo, quando começou e qualquer detalhe importante."
                    required
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group create-section">
                <label class="form-label">Anexos</label>

                <input
                    type="file"
                    name="anexos[]"
                    class="form-input file-simple"
                    multiple
                    accept="image/*,.pdf,.doc,.docx,.xls,.xlsx"
                >

               

                @error('anexos')
                    <div class="form-error">{{ $message }}</div>
                @enderror

                @error('anexos.*')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="create-actions">
                <a href="{{ route('tickets.index') }}" class="btn btn-ghost">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-primary">
                    Criar Chamado
                </button>
            </div>
        </form>
    </div>
</div>


</div>

@endsection
