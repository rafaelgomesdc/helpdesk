<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Help Desk')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-page: #050608;
            --bg-header: #090a0d;
            --bg-sidebar: #090a0d;
            --bg-card: #0d0f14;
            --bg-card-soft: #11141b;
            --bg-hover: #121a27;

            --border: rgba(59, 130, 246, 0.18);
            --border-soft: rgba(59, 130, 246, 0.08);

            --text-primary: #d7e7ff;
            --text-secondary: #a9c8f5;
            --text-muted: #6f8fbf;
            --text-faint: #3f5f8c;

            --accent: #2563eb;
            --accent-hover: #3b82f6;
            --accent-soft: rgba(37, 99, 235, 0.12);

            --success-bg: rgba(37, 99, 235, 0.10);
            --success-text: #a9c8f5;
            --error-bg: rgba(37, 99, 235, 0.10);
            --error-text: #a9c8f5;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif !important;
            background: var(--bg-page) !important;
            color: var(--text-primary) !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            font-size: 13px;
        }

        ::selection {
            background: rgba(59, 130, 246, 0.35);
            color: var(--text-primary);
        }

        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-page);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.35);
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.65);
        }

        a {
            color: var(--accent-hover);
            text-decoration: none;
        }

        a:hover {
            color: #72a5ff;
        }

        .header {
            height: 58px;
            background: var(--bg-header);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 22px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .hbrand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hbrand-icon {
            width: 32px;
            height: 32px;
            background: var(--bg-card);
            color: var(--accent-hover);
            border: 1px solid var(--border);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: -0.3px;
            box-shadow: 0 0 18px rgba(37, 99, 235, 0.08);
        }

        .hbrand-name {
            font-size: 14px;
            font-weight: 750;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .hbrand-sub {
            font-size: 10px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .hbadge {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 5px 10px;
            font-size: 11px;
            color: var(--text-secondary);
            font-weight: 600;
            max-width: 260px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .layout {
            display: flex;
            flex: 1;
            min-height: calc(100vh - 58px);
        }

        .sidebar {
            width: 220px;
            flex-shrink: 0;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 18px 0;
            position: fixed;
            top: 58px;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 40;
        }

        .sidebar-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.55px;
            text-transform: uppercase;
            color: var(--text-faint);
            padding: 0 18px;
            margin-bottom: 6px;
            margin-top: 13px;
            user-select: none;
        }

        .sidebar-label:first-child {
            margin-top: 0;
        }

        .sidebar-nav {
            padding: 0 10px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            transition: 0.15s ease;
            margin-bottom: 3px;
            min-height: 32px;
            line-height: 1.1;
        }

        .nav-item:hover {
            color: var(--text-primary);
            background: var(--bg-hover);
        }

        .nav-item.active {
            background: var(--accent-soft);
            color: var(--text-primary);
            font-weight: 650;
            box-shadow: inset 2px 0 0 var(--accent);
        }

        .nav-item svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            stroke-width: 1.8;
        }

        .sidebar-footer {
            padding: 14px 18px;
            border-top: 1px solid var(--border);
            font-size: 10px;
            color: var(--text-faint);
        }

        main {
            flex: 1;
            margin-left: 220px;
            padding: 26px 32px;
            position: relative;
            min-height: calc(100vh - 58px);
        }

        .flash {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            background: var(--success-bg);
            border: 1px solid var(--border);
            border-radius: 11px;
            color: var(--success-text);
            font-size: 12px;
            margin-bottom: 20px;
        }

        .flash-error {
            background: var(--error-bg);
            border-color: var(--border);
            color: var(--error-text);
        }

        .page-header {
            margin-bottom: 22px;
        }

        .page-title {
            font-size: 21px;
            font-weight: 720;
            color: var(--text-primary);
            letter-spacing: -0.35px;
            margin-bottom: 0;
        }

        .page-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
            margin-bottom: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(185px, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 16px;
            box-shadow: 0 0 24px rgba(37, 99, 235, 0.04);
            transition: 0.15s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-1px);
            border-color: rgba(59, 130, 246, 0.42);
            background: var(--bg-card-soft);
        }

        .stat-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.10), transparent 34%);
            pointer-events: none;
        }

        .stat-label {
            position: relative;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 9px;
            letter-spacing: 0.4px;
        }

        .stat-value {
            position: relative;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.8px;
            line-height: 1;
            color: var(--accent-hover) !important;
        }

        .stat-value.blue,
        .stat-value.green,
        .stat-value.amber,
        .stat-value.rose {
            color: var(--accent-hover) !important;
        }

        .stat-footer {
            position: relative;
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 8px;
        }

        .table-wrap {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 13px;
            overflow: hidden;
            box-shadow: 0 0 24px rgba(37, 99, 235, 0.04);
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-card);
        }

        .table-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.45px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 11px 18px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-header);
        }

        tbody td {
            padding: 12px 18px;
            font-size: 12px;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-soft);
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover td {
            background-color: var(--bg-hover);
            color: var(--text-primary);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 7px 13px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: 0.15s ease;
            font-family: 'Inter', sans-serif;
            line-height: 1.2;
        }

        .btn-primary {
            background: var(--accent);
            color: #050608;
            border: 1px solid var(--accent);
            box-shadow: 0 0 16px rgba(37, 99, 235, 0.12);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
            color: #050608;
            transform: translateY(-1px);
        }

        .btn-ghost {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .btn-ghost:hover {
            color: var(--text-primary);
            background: var(--bg-hover);
            border-color: var(--accent);
        }

        .btn-danger {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .btn-danger:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
            border-color: var(--accent);
        }

        .btn-sm {
            padding: 5px 9px;
            font-size: 11px;
            border-radius: 8px;
        }

        .form-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 22px;
            max-width: 720px;
            box-shadow: 0 0 24px rgba(37, 99, 235, 0.04);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            background-color: #080a0f;
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 9px 12px;
            font-size: 13px;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: 0.15s ease;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.14);
            background: var(--bg-header);
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--text-faint);
        }

        .form-select option {
            background: var(--bg-header);
            color: var(--text-primary);
        }

        .form-textarea {
            resize: vertical;
            min-height: 92px;
        }

        .form-error {
            font-size: 11px;
            color: var(--text-secondary);
            margin-top: 5px;
            display: block;
        }

        .form-actions {
            display: flex;
            gap: 9px;
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .empty-state {
            text-align: center;
            padding: 40px 18px;
            color: var(--text-muted);
        }

        .empty-icon {
            font-size: 26px;
            margin-bottom: 10px;
            opacity: 0.75;
        }

        .empty-text {
            font-size: 12px;
        }

        .badge {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
            border: 1px solid rgba(59, 130, 246, 0.25) !important;
            background: rgba(37, 99, 235, 0.12) !important;
            color: #bcd7ff !important;
        }

        .badge-green,
        .badge-amber,
        .badge-rose,
        .badge-blue,
        .badge-success,
        .badge-danger,
        .badge-warning,
        .badge-info,
        .badge-primary {
            background: rgba(37, 99, 235, 0.12) !important;
            color: #bcd7ff !important;
            border: 1px solid rgba(59, 130, 246, 0.25) !important;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 14px;
        }

        .detail-item {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 15px;
        }

        .detail-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 6px;
            letter-spacing: 0.35px;
        }

        .detail-value {
            font-size: 13px;
            color: var(--text-primary);
            font-weight: 600;
        }

        .perm-list {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 8px;
        }

        .perm-chip {
            background: rgba(37, 99, 235, 0.11);
            border: 1px solid rgba(59, 130, 246, 0.22);
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 11px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: 0.15s ease;
        }

        .perm-chip:hover {
            background: var(--bg-hover);
            border-color: var(--accent);
            color: var(--text-primary);
        }

        /* Força Bootstrap e dashboard a ficarem só em azul */
        .text-success,
        .text-danger,
        .text-warning,
        .text-info,
        .text-primary {
            color: var(--accent-hover) !important;
        }

        .bg-success,
        .bg-danger,
        .bg-warning,
        .bg-info,
        .bg-primary {
            background-color: rgba(37, 99, 235, 0.14) !important;
            color: var(--text-primary) !important;
            border-color: var(--border) !important;
        }

        .border-success,
        .border-danger,
        .border-warning,
        .border-info,
        .border-primary {
            border-color: var(--border) !important;
        }

        .alert,
        .alert-success,
        .alert-danger,
        .alert-warning,
        .alert-info,
        .alert-primary {
            background: rgba(37, 99, 235, 0.10) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-primary) !important;
            border-radius: 11px;
            font-size: 12px;
        }

        .card,
        .modal-content,
        .dropdown-menu,
        .list-group-item {
            background: var(--bg-card) !important;
            color: var(--text-primary) !important;
            border-color: var(--border) !important;
        }

        .dropdown-item {
            color: var(--text-secondary) !important;
        }

        .dropdown-item:hover {
            background: var(--bg-hover) !important;
            color: var(--text-primary) !important;
        }

        .text-muted,
        small,
        .small {
            color: var(--text-muted) !important;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-secondary);
            --bs-table-border-color: var(--border-soft);
            --bs-table-hover-bg: var(--bg-hover);
            --bs-table-hover-color: var(--text-primary);
        }

        canvas {
            max-width: 100%;
        }

        @media (max-width: 900px) {
            .sidebar {
                display: none;
            }

            main {
                margin-left: 0;
                padding: 22px 16px;
            }

            .header {
                padding: 0 16px;
            }

            .hbrand-sub {
                display: none;
            }

            .table-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .hbadge {
                max-width: 150px;
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            table {
                min-width: 720px;
            }

            .table-wrap {
                overflow-x: auto;
            }
        }
    </style>

    @stack('head')
</head>

<body>
<header class="header">
    <div class="hbrand">
        <div class="hbrand-icon">HD</div>
        <div>
            <div class="hbrand-name">Help Desk</div>
            <div class="hbrand-sub">Portal de Suporte</div>
        </div>
    </div>

    <div style="display:flex; align-items:center; gap:10px;">
        @auth
            <span class="hbadge">{{ auth()->user()->name }} · {{ auth()->user()->profile }}</span>

            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm" style="cursor:pointer;">
                    Sair
                </button>
            </form>
        @else
            <span class="hbadge">Fatec Prudente</span>
        @endauth
    </div>
</header>

<div class="layout">
    <aside class="sidebar">
        <div>
            <div class="sidebar-label">Principal</div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Dashboard
                </a>
            </nav>

            @auth
                <div class="sidebar-label">Chamados</div>

                <nav class="sidebar-nav">
                    <a href="{{ route('tickets.index') }}" class="nav-item {{ request()->routeIs('tickets.index') || request()->routeIs('tickets.show') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <path d="M14 2v6h6"/>
                        </svg>
                        Meus Chamados
                    </a>

                    <a href="{{ route('tickets.create') }}" class="nav-item {{ request()->routeIs('tickets.create') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Abrir Chamado
                    </a>
                </nav>

                @if(in_array(auth()->user()->profile, ['Admin', 'Técnico']))
                    <div class="sidebar-label">Técnico</div>

                    <nav class="sidebar-nav">
                        <a href="{{ route('technician.pending') }}" class="nav-item {{ request()->routeIs('technician.pending') ? 'active' : '' }}">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            Pendentes
                        </a>

                        <a href="{{ route('technician.in-progress') }}" class="nav-item {{ request()->routeIs('technician.in-progress') ? 'active' : '' }}">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                            </svg>
                            Atendimento
                        </a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('technician.manage') }}" class="nav-item {{ request()->routeIs('technician.manage') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <line x1="4" y1="21" x2="4" y2="14"/>
                                    <line x1="4" y1="10" x2="4" y2="3"/>
                                    <line x1="12" y1="21" x2="12" y2="12"/>
                                    <line x1="12" y1="8" x2="12" y2="3"/>
                                    <line x1="20" y1="21" x2="20" y2="16"/>
                                    <line x1="20" y1="12" x2="20" y2="3"/>
                                    <line x1="1" y1="14" x2="7" y2="14"/>
                                    <line x1="9" y1="8" x2="15" y2="8"/>
                                    <line x1="17" y1="16" x2="23" y2="16"/>
                                </svg>
                                Chamados
                            </a>
                        @endif
                    </nav>
                @endif

                <div class="sidebar-label">Conhecimento</div>

                <nav class="sidebar-nav">
                    <a href="{{ route('faqs.index') }}" class="nav-item {{ request()->routeIs('faqs.index') || request()->routeIs('faqs.show') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        FAQs
                    </a>

                    <a href="{{ route('artigos.index') }}" class="nav-item {{ request()->routeIs('artigos.index') || request()->routeIs('artigos.show') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                        </svg>
                        Artigos
                    </a>
                </nav>

                @if(auth()->user()->isAdmin())
                    <div class="sidebar-label">Configurações</div>

                    <nav class="sidebar-nav">
                        <a href="{{ route('categorias.index') }}" class="nav-item {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                            </svg>
                            Categorias
                        </a>

                        <a href="{{ route('prioridades.index') }}" class="nav-item {{ request()->routeIs('prioridades.*') ? 'active' : '' }}">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/>
                                <line x1="4" y1="22" x2="4" y2="15"/>
                            </svg>
                            Prioridades
                        </a>
                    </nav>

                    <div class="sidebar-label">Usuários</div>

                    <nav class="sidebar-nav">
                        <a href="{{ route('usuarios.index') }}" class="nav-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            Usuários
                        </a>

                        <a href="{{ route('setores.index') }}" class="nav-item {{ request()->routeIs('setores.*') ? 'active' : '' }}">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            </svg>
                            Setores
                        </a>

                        <a href="{{ route('cargos.index') }}" class="nav-item {{ request()->routeIs('cargos.*') ? 'active' : '' }}">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                            Cargos
                        </a>

                        <a href="{{ route('roles.index') }}" class="nav-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                            Perfis
                        </a>

                        <a href="{{ route('permissions.index') }}" class="nav-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Permissões
                        </a>
                    </nav>
                @endif
            @endauth
        </div>

        <div class="sidebar-footer">
            Laravel · Help Desk
        </div>
    </aside>

    <main>
        @if(session('sucesso'))
            <div class="flash">
                ✓ {{ session('sucesso') }}
            </div>
        @endif

        @if(session('erro'))
            <div class="flash flash-error">
                ⚠ {{ session('erro') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>