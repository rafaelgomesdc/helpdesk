<!DOCTYPE html>
<html lang="pt-BR">
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
        .form-textarea { resize:vertical; min-height:100px; }
        .form-select option { background:var(--bg-800); }
        .form-error { font-size:11px; color:#fb7185; margin-top:5px; }
        .form-actions { display:flex; gap:10px; margin-top:24px; padding-top:20px; border-top:1px solid var(--border); }
        .detail-card { background:var(--bg-900); border:1px solid var(--border); border-radius:14px; padding:28px; }
        .detail-meta { font-size:12px; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; margin-bottom:20px; }
        .detail-section-label { font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--text-muted); font-family:'IBM Plex Mono',monospace; margin-bottom:8px; }
        .detail-text { font-size:14px; color:var(--text-secondary); line-height:1.8; white-space:pre-wrap; }
        .empty-state { text-align:center; padding:48px 20px; color:var(--text-muted); }
        .empty-icon { font-size:32px; margin-bottom:12px; }
        .empty-text { font-size:14px; }
        .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; background:var(--bg-800); border:1px solid var(--border); color:var(--text-secondary); }
    </style>
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
        @if(session('user_name'))
            <span class="hbadge">{{ session('user_name') }} · {{ session('user_role') }}</span>
            <a href="{{ route('logout') }}" class="btn btn-ghost btn-sm"
               onclick="return confirm('Sair do sistema?')">Sair</a>
        @else
            <span class="hbadge">Fatec Prudente</span>
        @endif
    </div>
</header>

<div class="layout">
    <aside class="sidebar">
        <div>
            <div class="sidebar-label">Base de Conhecimento</div>
            <nav class="sidebar-nav">
                <a href="{{ route('faqs.index') }}"
                   class="nav-item {{ request()->routeIs('faqs.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    FAQs
                </a>
                <a href="{{ route('artigos.index') }}"
                   class="nav-item {{ request()->routeIs('artigos.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Artigos
                </a>
            </nav>

            @if(session('user_role') == 'admin')
            <div class="sidebar-label">Configurações</div>
            <nav class="sidebar-nav">
                <a href="{{ route('categorias.index') }}"
                   class="nav-item {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Categorias
                </a>
            </nav>
            @endif
        </div>
        <div class="sidebar-footer">Programação Web · Laravel</div>
    </aside>

    <main>
        @if(session('sucesso'))
            <div class="flash">✓ {{ session('sucesso') }}</div>
        @endif
        @if(session('erro'))
            <div class="flash flash-error">✗ {{ session('erro') }}</div>
        @endif
        @if(session('aviso'))
            <div class="flash" style="background:rgba(245,158,11,0.08); border-color:rgba(245,158,11,0.2); color:#fcd34d;">
                ⚠ {{ session('aviso') }}
            </div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
