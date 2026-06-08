<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Help Desk')</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg-950:#020617; --bg-900:#0f172a; --bg-850:#131e2e; --bg-800:#1e293b; --bg-700:#334155;
            --border:rgba(148,163,184,0.08); --text-primary:#f1f5f9; --text-secondary:#94a3b8; --text-muted:#475569;
            --blue-600:#2563eb; --blue-500:#3b82f6; --blue-400:#60a5fa;
            --emerald:#10b981; --amber:#f59e0b; --rose:#f43f5e;
        }
        body { font-family:'Inter',sans-serif; background:var(--bg-950); color:var(--text-primary); min-height:100vh; display:flex; flex-direction:column; }
        .header { height:56px; background:var(--bg-900); border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; padding:0 24px; position:sticky; top:0; z-index:40; }
        .hbrand { display:flex; align-items:center; gap:10px; }
        .hbrand-icon { width:30px; height:30px; background:linear-gradient(135deg,var(--blue-600),#7c3aed); border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:15px; }
        .hbrand-name { font-family:'IBM Plex Mono',monospace; font-size:13px; font-weight:700; color:var(--text-primary); }
        .hbrand-sub { font-family:'IBM Plex Mono',monospace; font-size:9px; color:var(--text-muted); letter-spacing:1px; text-transform:uppercase; }
        .hbadge { background:var(--bg-800); border:1px solid var(--border); border-radius:20px; padding:4px 12px; font-size:11px; color:var(--text-secondary); font-family:'IBM Plex Mono',monospace; }
        .layout { display:flex; flex:1; overflow:hidden; }
        .sidebar { width:240px; flex-shrink:0; background:var(--bg-900); border-right:1px solid var(--border); display:flex; flex-direction:column; justify-content:space-between; padding:24px 0; position:sticky; top:56px; height:calc(100vh - 56px); overflow-y:auto; }
        .sidebar-label { font-family:'IBM Plex Mono',monospace; font-size:9px; font-weight:800; letter-spacing:2px; text-transform:uppercase; color:var(--text-muted); padding:0 16px; margin-bottom:6px; margin-top:12px; }
        .sidebar-nav { padding:0 12px; }
        .nav-item { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; font-size:12px; font-weight:500; color:var(--text-secondary); text-decoration:none; transition:all 0.15s; margin-bottom:2px; }
        .nav-item:hover { color:var(--text-primary); background:var(--bg-800); }
        .nav-item.active { background:var(--blue-600); color:#fff; font-weight:700; }
        .nav-item svg { width:15px; height:15px; flex-shrink:0; }
        .sidebar-footer { padding:16px; border-top:1px solid var(--border); font-family:'IBM Plex Mono',monospace; font-size:9px; color:var(--text-muted); }
        main { flex:1; overflow-y:auto; padding:32px 40px; }
        .flash { display:flex; align-items:center; gap:10px; padding:12px 16px; background:rgba(16,185,129,0.08); border:1px solid rgba(16,185,129,0.2); border-radius:10px; color:#34d399; font-size:13px; margin-bottom:20px; }
        .flash-error { background:rgba(244,63,94,0.08); border-color:rgba(244,63,94,0.2); color:#fb7185; }
        .page-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:28px; gap:16px; flex-wrap:wrap; }
        .page-title { font-size:22px; font-weight:700; color:var(--text-primary); letter-spacing:-0.5px; }
        .page-subtitle { font-size:13px; color:var(--text-muted); margin-top:4px; }
        .stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; margin-bottom:28px; }
        .stat-card { background:var(--bg-900); border:1px solid var(--border); border-radius:14px; padding:20px; position:relative; overflow:hidden; }
        .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; }
        .stat-card.blue::before { background:linear-gradient(90deg,var(--blue-600),var(--blue-400)); }
        .stat-card.green::before { background:linear-gradient(90deg,var(--emerald),#34d399); }
        .stat-card.amber::before { background:linear-gradient(90deg,var(--amber),#fcd34d); }
        .stat-card.rose::before { background:linear-gradient(90deg,var(--rose),#fb7185); }
        .stat-label { font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; margin-bottom:10px; }
        .stat-value { font-size:36px; font-weight:800; letter-spacing:-1px; line-height:1; }
        .stat-value.blue{color:var(--blue-400);} .stat-value.green{color:#34d399;} .stat-value.amber{color:#fcd34d;} .stat-value.rose{color:#fb7185;font-size:28px;}
        .stat-footer { font-size:11px; color:var(--text-muted); margin-top:8px; }
        .table-wrap { background:var(--bg-900); border:1px solid var(--border); border-radius:14px; overflow:hidden; }
        .table-header { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid var(--border); }
        .table-title { font-size:13px; font-weight:600; color:var(--text-primary); }
        table { width:100%; border-collapse:collapse; }
        thead th { text-align:left; font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; padding:12px 20px; border-bottom:1px solid var(--border); background:var(--bg-850); }
        tbody td { padding:14px 20px; font-size:13px; color:var(--text-secondary); border-bottom:1px solid var(--border); vertical-align:middle; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover td { background:var(--bg-850); }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:all 0.15s; font-family:'Inter',sans-serif; }
        .btn-primary{background:var(--blue-600);color:#fff;} .btn-primary:hover{background:var(--blue-500);}
        .btn-ghost{background:var(--bg-800);border:1px solid var(--border);color:var(--text-secondary);} .btn-ghost:hover{color:var(--text-primary);background:var(--bg-700);}
        .btn-danger{background:rgba(244,63,94,0.1);border:1px solid rgba(244,63,94,0.2);color:#fb7185;} .btn-danger:hover{background:rgba(244,63,94,0.2);}
        .btn-sm{padding:5px 10px;font-size:11px;}
        .form-card { background:var(--bg-900); border:1px solid var(--border); border-radius:14px; padding:28px; max-width:720px; }
        .form-group { margin-bottom:18px; }
        .form-label { display:block; font-size:11px; font-weight:600; letter-spacing:0.5px; text-transform:uppercase; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; margin-bottom:8px; }
        .form-input,.form-textarea,.form-select { width:100%; background:var(--bg-850); border:1px solid var(--border); border-radius:8px; padding:10px 14px; font-size:13px; color:var(--text-primary); font-family:'Inter',sans-serif; outline:none; transition:border-color 0.15s; }
        .form-input:focus,.form-textarea:focus,.form-select:focus { border-color:var(--blue-500); box-shadow:0 0 0 3px rgba(59,130,246,0.1); }
        .form-textarea { resize:vertical; min-height:90px; }
        .form-error { font-size:11px; color:#fb7185; margin-top:5px; }
        .form-actions { display:flex; gap:10px; margin-top:24px; padding-top:20px; border-top:1px solid var(--border); }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .progress-wrap { margin-bottom:14px; }
        .progress-top { display:flex; justify-content:space-between; margin-bottom:6px; }
        .progress-name { font-size:13px; color:var(--text-secondary); }
        .progress-count { font-family:'IBM Plex Mono',monospace; font-size:12px; color:var(--text-muted); }
        .progress-bar { height:6px; background:var(--bg-800); border-radius:99px; overflow:hidden; }
        .progress-fill { height:100%; border-radius:99px; background:linear-gradient(90deg,var(--blue-600),var(--blue-400)); }
        .empty-state { text-align:center; padding:48px 20px; color:var(--text-muted); }
        .empty-icon { font-size:32px; margin-bottom:12px; }
        .empty-text { font-size:14px; }
        .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-green { background:rgba(16,185,129,0.15); color:#34d399; }
        .badge-amber { background:rgba(245,158,11,0.15); color:#fcd34d; }
        .badge-rose { background:rgba(244,63,94,0.15); color:#fb7185; }
        .badge-blue { background:rgba(59,130,246,0.15); color:#60a5fa; }
        .detail-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:16px; }
        .detail-item { background:var(--bg-850); border:1px solid var(--border); border-radius:10px; padding:16px; }
        .detail-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; margin-bottom:6px; }
        .detail-value { font-size:14px; color:var(--text-primary); }
        .perm-list { display:flex; flex-wrap:wrap; gap:8px; margin-top:8px; }
        .perm-chip { background:var(--bg-800); border:1px solid var(--border); border-radius:8px; padding:6px 12px; font-size:12px; }
        @media (max-width:768px) { .form-grid { grid-template-columns:1fr; } .sidebar { display:none; } }
    </style>
    <link rel="stylesheet" href="/css/base.css">
    @stack('styles')
</head>
<body>
<header class="header">
    <div class="hbrand">
        <div class="hbrand-icon">🎧</div>
        <div>
            <div class="hbrand-name">Help Desk</div>
            <div class="hbrand-sub">Portal de Suporte</div>
        </div>
    </div>
    <div style="display:flex; align-items:center; gap:12px;">
        @auth
            <span class="hbadge">{{ auth()->user()->name }} · {{ auth()->user()->profile }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm" style="cursor:pointer;">Sair</button>
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
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('categorias.index') }}" class="nav-item {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    Categorias
                </a>
                <a href="{{ route('tickets.index') }}" 
                class="nav-item {{ request()->routeIs('tickets.index') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Meus Chamados
                </a>
            </nav>

            @auth
            @if(auth()->user()->isAdmin())
            <div class="sidebar-label">Controle de Usuários</div>
            <nav class="sidebar-nav">
                <a href="{{ route('usuarios.index') }}" class="nav-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Usuários
                </a>
                <a href="{{ route('setores.index') }}" class="nav-item {{ request()->routeIs('setores.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    Setores
                </a>
                <a href="{{ route('cargos.index') }}" class="nav-item {{ request()->routeIs('cargos.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    Cargos
                </a>
                <a href="{{ route('roles.index') }}" class="nav-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Perfis
                </a>
                <a href="{{ route('permissions.index') }}" class="nav-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Permissões
                </a>
            </nav>
            @endif

            @if(auth()->user()->isAdmin())
            <div class="sidebar-label">Configurações</div>
            <nav class="sidebar-nav">
                <a href="{{ route('prioridades.index') }}" class="nav-item {{ request()->routeIs('prioridades.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                    Prioridades
                </a>
            </nav>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->profile === 'Technician')
            <div class="sidebar-label">Análises</div>
            <nav class="sidebar-nav">
                <a href="{{ route('relatorios.tempo-medio') }}" class="nav-item {{ request()->routeIs('relatorios.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Tempo Médio
                </a>
            </nav>
            @endif

            @endauth

            <div class="sidebar-label">Base de Conhecimento</div>
            <nav class="sidebar-nav">
                <a href="{{ route('faqs.index') }}" class="nav-item {{ request()->routeIs('faqs.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    FAQs
                </a>
                <a href="{{ route('artigos.index') }}" class="nav-item {{ request()->routeIs('artigos.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Artigos
                </a>
            </nav>
        </div>
        <div class="sidebar-footer">Programação Web · Laravel</div>
    </aside>
    <main>
        @if(session('sucesso'))
            <div class="flash">✓ {{ session('sucesso') }}</div>
        @endif
        @if(session('erro'))
            <div class="flash flash-error">⚠ {{ session('erro') }}</div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
