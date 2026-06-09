@extends('layouts.portal')

@section('title', 'Portal de Service Desk - Solicitar Registro')

@section('width', '640px')

@section('content')
  <div class="portal-card">

    <div class="text-center mb-4">
      <div class="portal-title-icon" style="border-color: rgba(16, 185, 129, 0.3); color: var(--emerald-500); background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(20, 184, 166, 0.1));">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 2rem; height: 2rem;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
      </div>
      <h1 class="h4 fw-bold text-white mb-2">Solicitar Cadastro</h1>
      <p class="text-secondary small max-w-md mx-auto mb-0">Inscreva-se na infraestrutura de TI corporativa. Todo cadastro passará por aprovação prévia do administrador.</p>
    </div>

    @if($errors->any())
    <div class="alert-portal alert-portal-danger">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      <div>
        <p class="fw-bold mb-1" style="color: #fda4af;">Falha ao preencher cadastro</p>
        <p class="mb-0 text-white-50 small" style="font-size: 11px;">{{ $errors->first() }}</p>
      </div>
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="portal-label">Nome Completo</label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Amanda Ferreira Silva" class="portal-control" required>
        </div>
        <div class="col-md-6">
          <label class="portal-label">Telefone / Ramal</label>
          <input type="text" name="contact" value="{{ old('contact') }}" oninput="applyPhoneMask(this)" placeholder="Ex: (11) 99999-9999" class="portal-control" required>
        </div>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="portal-label">Setor / Departamento</label>
          <select name="setor_id" class="portal-control" style="cursor:pointer;" required>
            <option value="" disabled {{ old('setor_id') ? '' : 'selected' }}>Selecione um setor...</option>
            @foreach($setores as $setor)
              <option value="{{ $setor->id }}" {{ old('setor_id') == $setor->id ? 'selected' : '' }}>{{ $setor->nome }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="portal-label">Cargo / Função exercida</label>
          <select name="cargo_id" class="portal-control" style="cursor:pointer;" required>
            <option value="" disabled {{ old('cargo_id') ? '' : 'selected' }}>Selecione um cargo...</option>
            @foreach($cargos as $cargo)
              <option value="{{ $cargo->id }}" {{ old('cargo_id') == $cargo->id ? 'selected' : '' }}>{{ $cargo->nome }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="mb-3">
        <label class="portal-label">Endereço Residencial</label>
        <input type="text" name="address" value="{{ old('address') }}" placeholder="Rua, número, bairro, cidade..." class="portal-control">
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="portal-label">E-mail Corporativo</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="Ex: amanda.silva@empresa.com" class="portal-control" required>
        </div>
        <div class="col-md-6">
          <label class="portal-label">Nível de Acesso Solicitado</label>
          <select name="profile" class="portal-control" style="cursor:pointer;" required>
            <option value="Usuário" {{ old('profile', 'Usuário') == 'Usuário' ? 'selected' : '' }}>Usuário Solicitante (Comum)</option>
            <option value="Técnico" {{ old('profile') == 'Técnico' ? 'selected' : '' }}>Técnico Analista (Suporte HelpDesk)</option>
          </select>
        </div>
      </div>

      <div class="mb-3">
        <label class="portal-label">E-mail Pessoal (Opcional)</label>
        <input type="email" name="email_pessoal" value="{{ old('email_pessoal') }}" placeholder="Ex: amanda@gmail.com" class="portal-control">
      </div>

      <div class="mb-3">
        <label class="portal-label">Definir Senha de Acesso</label>
        <input type="password" name="password" id="reg-password" oninput="checkPasswordStrength(this.value)" placeholder="Mínimo 6 caracteres" class="portal-control" required>
        <div class="mt-2 d-flex align-items-center gap-2">
          <span class="text-secondary font-sans uppercase tracking-wide select-none" style="font-size: 9px; font-weight: 700;">Força:</span>
          <div class="flex-grow-1" style="height: 6px; background-color: var(--bg-950); border-radius: 4px; display: flex; gap: 4px; overflow: hidden;">
            <div id="bar-1" class="h-100 flex-grow-1" style="background-color: var(--bg-850); transition: background-color 0.2s;"></div>
            <div id="bar-2" class="h-100 flex-grow-1" style="background-color: var(--bg-850); transition: background-color 0.2s;"></div>
            <div id="bar-3" class="h-100 flex-grow-1" style="background-color: var(--bg-850); transition: background-color 0.2s;"></div>
          </div>
          <span id="strength-label" class="fw-bold uppercase" style="font-size: 10px; color: var(--text-muted);">INCOMPLETA</span>
        </div>
      </div>

      <div class="p-3 mb-4 rounded" style="background: rgba(2, 6, 23, 0.45); border: 1px solid rgba(148, 163, 184, 0.08);">
        <div class="mb-3">
          <label class="portal-label">Pergunta de Segurança de Resgate</label>
          <select name="question" class="portal-control" style="cursor:pointer;" required>
            <option value="Qual o nome do seu primeiro animal de estimação?" {{ old('question') == 'Qual o nome do seu primeiro animal de estimação?' ? 'selected' : '' }}>Qual o nome do seu primeiro animal de estimação?</option>
            <option value="Qual a sua cidade natal?" {{ old('question') == 'Qual a sua cidade natal?' ? 'selected' : '' }}>Qual a sua cidade natal?</option>
            <option value="Qual a marca do seu primeiro carro?" {{ old('question') == 'Qual a marca do seu primeiro carro?' ? 'selected' : '' }}>Qual a marca do seu primeiro carro?</option>
            <option value="Qual o nome de solteira da sua mãe?" {{ old('question') == 'Qual o nome de solteira da sua mãe?' ? 'selected' : '' }}>Qual o nome de solteira da sua mãe?</option>
          </select>
        </div>
        <div>
          <label class="portal-label">Sua Resposta Confidencial</label>
          <input type="text" name="answer" value="{{ old('answer') }}" placeholder="Digite a resposta secreta para futuras recuperações" class="portal-control" required>
        </div>
      </div>

      <button type="submit" class="portal-btn-primary w-100 mb-3" style="background-color: var(--emerald-500);">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 1rem; height: 1rem;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg>
        <span>Enviar Solicitação de Cadastro</span>
      </button>

      <div class="text-center pt-2">
        <a href="{{ route('login') }}" class="portal-link" style="color: var(--blue-500); font-weight: 700;">
          ← Voltar para a Tela de Login
        </a>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  function applyPhoneMask(input) {
    let value = input.value.replace(/\D/g, "");
    if (value.length > 11) value = value.substring(0, 11);

    if (value.length > 6) {
      value = `(${value.substring(0, 2)}) ${value.substring(2, 7)}-${value.substring(7)}`;
    } else if (value.length > 2) {
      value = `(${value.substring(0, 2)}) ${value.substring(2)}`;
    } else if (value.length > 0) {
      value = `(${value}`;
    }
    input.value = value;
  }

  function checkPasswordStrength(password) {
    const bar1 = document.getElementById('bar-1');
    const bar2 = document.getElementById('bar-2');
    const bar3 = document.getElementById('bar-3');
    const label = document.getElementById('strength-label');

    bar1.style.backgroundColor = 'var(--bg-850)';
    bar2.style.backgroundColor = 'var(--bg-850)';
    bar3.style.backgroundColor = 'var(--bg-850)';

    if (!password) {
      label.innerText = 'INCOMPLETA';
      label.style.color = 'var(--text-muted)';
      return;
    }

    if (password.length < 6) {
      bar1.style.backgroundColor = 'var(--rose-500)';
      label.innerText = 'FRACA (MÍN. 6 CAR.)';
      label.style.color = 'var(--rose-500)';
      return;
    }

    const hasNumber = /\d/.test(password);
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    if (hasNumber && hasSpecial) {
      bar1.style.backgroundColor = 'var(--emerald-500)';
      bar2.style.backgroundColor = 'var(--emerald-500)';
      bar3.style.backgroundColor = 'var(--emerald-500)';
      label.innerText = 'FORTE (RECOMENDADA)';
      label.style.color = 'var(--emerald-500)';
    } else if (hasNumber || hasSpecial) {
      bar1.style.backgroundColor = 'var(--amber-500)';
      bar2.style.backgroundColor = 'var(--amber-500)';
      label.innerText = 'MÉDIA';
      label.style.color = 'var(--amber-500)';
    } else {
      bar1.style.backgroundColor = 'var(--rose-500)';
      label.innerText = 'FRACA';
      label.style.color = 'var(--rose-500)';
    }
  }
</script>
@endpush
