@extends('layouts.portal')

@section('title', 'Portal de Service Desk - Login')

@section('content')
  <div class="portal-card">

    <div class="text-center mb-4">
      <div class="portal-title-icon mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 2.5rem; height: 2.5rem;"><line x1="3" y1="22" x2="21" y2="22"></line><line x1="6" y1="18" x2="6" y2="11"></line><line x1="10" y1="18" x2="10" y2="11"></line><line x1="14" y1="18" x2="14" y2="11"></line><line x1="18" y1="18" x2="18" y2="11"></line><path d="m12 2-10 9h20z"></path></svg>
      </div>
      <h1 class="h3 fw-bold text-white mb-2">Portal de Service Desk</h1>
      <p class="text-secondary small max-w-md mx-auto mb-0" style="line-height: 1.5;">
        Sistema de Gestão de Chamados & Suporte Técnico Corporativo
      </p>
      <div class="d-flex justify-content-center gap-3 mt-3">
        <div class="feature-badge">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          <span>Seguro</span>
        </div>
        <div class="feature-badge">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          <span>Rápido</span>
        </div>
        <div class="feature-badge">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          <span>Colaborativo</span>
        </div>
      </div>
    </div>

    @if (session('error'))
    <div class="alert-portal alert-portal-danger">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      <div>
        <p class="fw-bold mb-1" style="color: #fda4af;">Erro de Segurança</p>
        <p class="mb-0 text-white-50 small" style="font-size: 11px;">{{ session('error') }}</p>
      </div>
    </div>
    @endif

    @if (session('success'))
    <div class="alert-portal alert-portal-success">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275Z"></path></svg>
      <div>
        <p class="fw-bold mb-1" style="color: #6ee7b7;">Operação bem-sucedida</p>
        <p class="mb-0 text-white-50 small" style="font-size: 11px;">{{ session('success') }}</p>
      </div>
    </div>
    @endif

    <form id="login-form" method="POST" action="{{ route('login.auth') }}">
      @csrf
      <div class="mb-3">
        <label class="portal-label">E-mail Corporativo</label>
        <div class="portal-input-group">
          <input
            id="email-input"
            name="email"
            type="email"
            value="{{ old('email') }}"
            placeholder="ex: admin@helpdesk.com"
            class="portal-control"
            style="padding-right: 2.5rem;"
            required
          />
          <div style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-family: sans-serif;">@</div>
        </div>
        <p class="text-muted small mt-1" style="font-size: 10px;">Use seu e-mail institucional para acessar o sistema</p>
      </div>

      <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <label class="portal-label mb-0">Senha de Segurança</label>
          <a href="{{ route('password.request') }}" class="portal-link">
            Esqueci a Senha ?
          </a>
        </div>
        <div class="portal-input-group">
          <input
            id="password-input"
            name="password"
            type="password"
            placeholder="••••••••"
            class="portal-control"
            style="padding-right: 2.5rem;"
            required
          />
          <button type="button" onclick="togglePasswordVisibility('password-input')" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 1rem; height: 1rem;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          </button>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-4 pt-1">
        <div class="tls-badge">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 11 2 2 4-4"></path></svg>
          Conexão TLS 1.3 ativa
        </div>
        <div class="text-muted small" style="font-size: 10px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          v2.0
        </div>
      </div>

      <button type="submit" class="portal-btn-primary w-100 mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 1rem; height: 1rem;"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
        <span>Validar & Entrar no Sistema</span>
      </button>

      <div class="text-center pt-2">
        <span class="small text-secondary" style="font-size: 11px;">Novo colaborador? </span>
        <a href="{{ route('register.form') }}" class="portal-link-secondary ms-1">
          Solicitar Cadastro de Acesso →
        </a>
      </div>
    </form>

    <div class="text-center mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
      <p class="text-muted small mb-2" style="font-size: 10px;">Precisa de ajuda? Entre em contato com o suporte técnico</p>
      <div class="d-flex justify-content-center gap-4">
        <a href="#" class="text-muted small" style="font-size: 10px; text-decoration: none; color: var(--text-muted);">📧 suporte@helpdesk.com</a>
        <a href="#" class="text-muted small" style="font-size: 10px; text-decoration: none; color: var(--text-muted);">📞 (11) 3333-4444</a>
      </div>
    </div>

  </div>
@endsection

@push('scripts')
<script>
  function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
  }
</script>
@endpush

@push('styles')
<style>
  .feature-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 20px;
    font-size: 10px;
    color: var(--blue-400);
    font-weight: 500;
  }
</style>
@endpush
