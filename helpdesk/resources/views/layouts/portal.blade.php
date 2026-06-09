<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Portal de Service Desk')</title>

  <!-- Google Fonts: Inter & IBM Plex Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    :root {
      --bg-950: #020617;
      --bg-900: #0f172a;
      --bg-850: #1e293b;
      --border: rgba(148, 163, 184, 0.08);
      --text-primary: #f1f5f9;
      --text-secondary: #94a3b8;
      --text-muted: #475569;
      --blue-500: #3b82f6;
      --blue-600: #2563eb;
      --emerald-500: #10b981;
      --rose-500: #f43f5e;
      --amber-500: #f59e0b;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-950);
      color: var(--text-primary);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem 1rem;
      position: relative;
      overflow-y: auto;
      margin: 0;
    }

    .grid-overlay {
      position: absolute;
      inset: 0;
      background-image: linear-gradient(to right, #0f172a 1px, transparent 1px), 
                        linear-gradient(to bottom, #0f172a 1px, transparent 1px);
      background-size: 4rem 4rem;
      mask-image: radial-gradient(ellipse 60% 50% at 50% 50%, #000 70%, transparent 100%);
      -webkit-mask-image: radial-gradient(ellipse 60% 50% at 50% 50%, #000 70%, transparent 100%);
      opacity: 0.35;
      pointer-events: none;
      z-index: 1;
    }

    .blur-spot-1 {
      position: absolute;
      top: 20%;
      left: 10%;
      width: 24rem;
      height: 24rem;
      background: rgba(37, 99, 235, 0.08);
      border-radius: 50%;
      filter: blur(80px);
      pointer-events: none;
      z-index: 1;
    }

    .blur-spot-2 {
      position: absolute;
      bottom: 20%;
      right: 10%;
      width: 24rem;
      height: 24rem;
      background: rgba(16, 185, 129, 0.08);
      border-radius: 50%;
      filter: blur(80px);
      pointer-events: none;
      z-index: 1;
    }

    .portal-wrapper {
      width: 100%;
      max-width: @yield('width', '540px');
      position: relative;
      z-index: 10;
      margin: auto;
    }

    /* Estilo do Card Portal (Mesmo visual que o original) */
    .portal-card {
      background: rgba(15, 23, 42, 0.85);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid var(--border);
      border-radius: 1.5rem;
      padding: 2.5rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      transition: all 0.3s ease;
    }

    .portal-card:hover {
      border-color: rgba(59, 130, 246, 0.15);
    }

    .portal-title-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(99, 102, 241, 0.1));
      border: 1px solid rgba(59, 130, 246, 0.3);
      color: var(--blue-500);
      border-radius: 1.2rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.05);
    }

    .portal-input-group {
      position: relative;
    }

    .portal-control {
      width: 100%;
      background-color: rgba(2, 6, 23, 0.8);
      border: 1px solid var(--border);
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      color: var(--text-primary);
      font-family: 'IBM Plex Mono', monospace;
      font-size: 0.875rem;
      transition: all 0.2s ease;
    }

    .portal-control:focus {
      outline: none;
      background-color: var(--bg-950);
      border-color: var(--blue-500);
      box-shadow: 0 0 0 1px var(--blue-500);
      color: var(--text-primary);
    }

    .portal-control::placeholder {
      color: var(--text-muted);
    }

    .portal-label {
      font-size: 0.65rem;
      font-weight: 700;
      color: var(--text-secondary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 0.5rem;
      display: block;
    }

    .portal-btn-primary {
      background-color: var(--blue-600);
      border: none;
      border-radius: 0.75rem;
      color: #fff;
      font-size: 0.875rem;
      font-weight: 600;
      padding: 0.75rem 1.25rem;
      transition: all 0.2s ease;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .portal-btn-primary:hover {
      background-color: var(--blue-500);
      box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
    }

    .portal-btn-primary:active {
      background-color: rgba(37, 99, 235, 0.8);
    }

    .portal-link {
      color: var(--blue-500);
      text-decoration: none;
      font-size: 0.65rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      transition: color 0.15s ease;
    }

    .portal-link:hover {
      color: #93c5fd;
    }

    .portal-link-secondary {
      color: var(--emerald-500);
      text-decoration: none;
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      transition: color 0.15s ease;
    }

    .portal-link-secondary:hover {
      color: #a7f3d0;
    }

    .alert-portal {
      border-radius: 0.75rem;
      padding: 1rem;
      font-size: 0.75rem;
      margin-bottom: 1.5rem;
      border: 1px solid transparent;
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
    }

    .alert-portal-danger {
      background-color: rgba(244, 63, 94, 0.1);
      border-color: rgba(244, 63, 94, 0.2);
      color: #fecdd3;
    }

    .alert-portal-success {
      background-color: rgba(16, 185, 129, 0.1);
      border-color: rgba(16, 185, 129, 0.2);
      color: #a7f3d0;
    }

    .tls-badge {
      font-size: 0.7rem;
      color: var(--text-secondary);
      display: flex;
      align-items: center;
      gap: 0.35rem;
    }
  </style>
  @stack('head')
</head>
<body>

  <!-- Efeitos de Fundo de Grade e Blur -->
  <div class="grid-overlay"></div>
  <div class="blur-spot-1"></div>
  <div class="blur-spot-2"></div>

  <!-- Container de Conteúdo -->
  <div class="portal-wrapper">
    @yield('content')
  </div>

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
