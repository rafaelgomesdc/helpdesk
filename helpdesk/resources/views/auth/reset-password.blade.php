@extends('layouts.portal')

@section('title', 'Portal de Service Desk - Recuperar Senha')

@section('content')
  <style>
    .hidden {
      display: none !important;
    }
  </style>

  <div class="portal-card">

    <div class="text-center mb-4">
      <div class="portal-title-icon" style="border-color: rgba(245, 158, 11, 0.3); color: var(--amber-500); background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(249, 115, 22, 0.1));">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 2rem; height: 2rem;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
      </div>
      <h1 class="h4 fw-bold text-white mb-2">Recuperação de Senha</h1>
      <p class="text-secondary small max-w-md mx-auto mb-0">Resgate seu acesso corporativo usando perguntas secretas criptografadas.</p>
    </div>

    <!-- Banner de Erro -->
    <div id="error-banner" class="alert-portal alert-portal-danger hidden">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      <div>
        <p class="fw-bold mb-1" style="color: #fda4af;">Falha no Processo</p>
        <p id="error-message" class="mb-0 text-white-50 small" style="font-size: 11px;"></p>
      </div>
    </div>

    <!-- Banner de Sucesso -->
    <div id="success-banner" class="alert-portal alert-portal-success hidden">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275Z"></path></svg>
      <div>
        <p class="fw-bold mb-1" style="color: #6ee7b7;">Sucesso Corporativo</p>
        <p id="success-message" class="mb-0 text-white-50 small" style="font-size: 11px;"></p>
      </div>
    </div>

    <!-- Etapa 1: Identificar Colaborador -->
    <form id="recovery-step1" onsubmit="handleFindEmail(event)">
      <div class="mb-3">
        <h3 class="h6 fw-bold text-white mb-1">
          <span style="color: var(--amber-500);">01</span> Identificar Colaborador
        </h3>
        <p class="text-secondary small">Para iniciar o restauro seguro, digite seu e-mail corporativo cadastrado.</p>
      </div>
      <div class="mb-4">
        <label class="portal-label">E-mail Cadastrado</label>
        <input id="recovery-email-input" type="email" placeholder="ex: admin@helpdesk.com" class="portal-control" required>
      </div>
      <div class="d-flex gap-3 pt-2">
        <a href="{{ route('login') }}" class="portal-btn-primary w-50" style="background: transparent; border: 1px solid var(--border); color: var(--text-secondary);">Cancelar</a>
        <button type="submit" class="portal-btn-primary w-50">Localizar Registro</button>
      </div>
    </form>

    <!-- Etapa 2: Responder Questão Secundária -->
    <form id="recovery-step2" onsubmit="handleVerifyAnswer(event)" class="hidden">
      <div class="mb-3">
        <h3 class="h6 fw-bold text-white mb-1">
          <span style="color: var(--amber-500);">02</span> Responder Questão Secundária
        </h3>
        <p class="text-secondary small">Conta localizada: <span id="recovery-user-name" class="fw-bold" style="color: var(--blue-500);"></span>. Responda à questão pessoal guardada na criação de sua credencial.</p>
      </div>
      <div class="p-3 mb-3 rounded" style="background: rgba(2, 6, 23, 0.6); border: 1px solid rgba(148, 163, 184, 0.08);">
        <span class="d-block portal-label mb-1" style="color: var(--text-muted);">Questão Definida:</span>
        <span id="recovery-question-text" class="small text-white fst-italic fw-medium"></span>
      </div>
      <div class="mb-4">
        <label class="portal-label">Sua Resposta</label>
        <input id="security-answer-input" type="text" placeholder="Digite a resposta confidencial..." class="portal-control" required>
      </div>
      <div class="d-flex gap-3 pt-2">
        <button type="button" onclick="backToStep1()" class="portal-btn-primary w-50" style="background: transparent; border: 1px solid var(--border); color: var(--text-secondary);">Voltar</button>
        <button type="submit" class="portal-btn-primary w-50">Confirmar Resposta</button>
      </div>
    </form>

    <!-- Etapa 3: Gravar Credencial Nova -->
    <form id="recovery-step3" onsubmit="handleResetPassword(event)" class="hidden">
      <div class="mb-3">
        <h3 class="h6 fw-bold text-white mb-1">
          <span style="color: var(--emerald-500);">03</span> Gravar Credencial Nova
        </h3>
        <p class="text-secondary small">Verificação concluída com sucesso! Redefina com segurança a sua nova chave.</p>
      </div>
      <div class="mb-4">
        <label class="portal-label">Nova Senha Corporativa</label>
        <div class="portal-input-group">
          <input id="new-password-input" type="password" placeholder="Digite ao menos 6 caracteres" class="portal-control" style="padding-right: 2.5rem;" required>
          <button type="button" onclick="togglePasswordVisibility()" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 1rem; height: 1rem;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          </button>
        </div>
      </div>
      <div class="d-flex gap-3 pt-2">
        <a href="{{ route('login') }}" class="portal-btn-primary w-50" style="background: transparent; border: 1px solid var(--border); color: var(--text-secondary);">Desistir</a>
        <button type="submit" class="portal-btn-primary w-50" style="background-color: var(--emerald-500);">Salvar Nova Senha</button>
      </div>
    </form>

  </div>
@endsection

@push('scripts')
<script>
  const resetPasswordUrl = "{{ route('password.ajax') }}";
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

  let recoveryUser = null;

  function togglePasswordVisibility() {
    const input = document.getElementById('new-password-input');
    input.type = input.type === 'password' ? 'text' : 'password';
  }

  function showError(msg) {
    document.getElementById('error-message').innerText = msg;
    document.getElementById('error-banner').classList.remove('hidden');
    document.getElementById('success-banner').classList.add('hidden');
  }

  function showSuccess(msg) {
    document.getElementById('success-message').innerText = msg;
    document.getElementById('success-banner').classList.remove('hidden');
    document.getElementById('error-banner').classList.add('hidden');
  }

  function hideBanners() {
    document.getElementById('error-banner').classList.add('hidden');
    document.getElementById('success-banner').classList.add('hidden');
  }

  function backToStep1() {
    hideBanners();
    document.getElementById('recovery-step1').classList.remove('hidden');
    document.getElementById('recovery-step2').classList.add('hidden');
    document.getElementById('recovery-step3').classList.add('hidden');
    recoveryUser = null;
  }

  async function postResetAction(payload) {
    const response = await fetch(resetPasswordUrl, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify(payload)
    });

    return response.json();
  }

  async function handleFindEmail(event) {
    event.preventDefault();
    hideBanners();
    const email = document.getElementById('recovery-email-input').value.trim();
    if (!email) return showError('Informe o e-mail cadastrado.');

    const data = await postResetAction({ action: 'find', email });
    if (!data.success) return showError(data.message);

    recoveryUser = data.user;
    document.getElementById('recovery-user-name').innerText = recoveryUser.name;
    document.getElementById('recovery-question-text').innerText = `"${recoveryUser.securityQuestion}"`;
    document.getElementById('recovery-step1').classList.add('hidden');
    document.getElementById('recovery-step2').classList.remove('hidden');
  }

  async function handleVerifyAnswer(event) {
    event.preventDefault();
    hideBanners();
    if (!recoveryUser) return showError('Sessão expirada, reinicie o processo.');
    const answer = document.getElementById('security-answer-input').value.trim();
    if (!answer) return showError('Digite a resposta secreta.');

    const data = await postResetAction({
      action: 'verify',
      email: recoveryUser.email,
      answer
    });
    if (!data.success) return showError(data.message);

    document.getElementById('recovery-step2').classList.add('hidden');
    document.getElementById('recovery-step3').classList.remove('hidden');
  }

  async function handleResetPassword(event) {
    event.preventDefault();
    hideBanners();
    if (!recoveryUser) return showError('Sessão expirada, reinicie o processo.');
    const newPassword = document.getElementById('new-password-input').value;
    if (!newPassword || newPassword.length < 6) return showError('A nova senha deve ter no mínimo 6 caracteres.');

    const data = await postResetAction({
      action: 'reset',
      email: recoveryUser.email,
      newPassword
    });
    if (!data.success) return showError(data.message);

    showSuccess(`Nova senha configurada com sucesso para ${recoveryUser.name}. Redirecionando para login...`);
    setTimeout(() => { window.location.href = "{{ route('login') }}"; }, 2500);
  }
</script>
@endpush
