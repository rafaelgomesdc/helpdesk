@extends('layouts.portal')

@section('title', 'Portal de Service Desk - Solicitar Registro')

@section('width', 'max-w-xl')

@section('content')
  <div class="bg-slate-900/85 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl transition-all duration-300">

    <div class="text-center mb-6">
      <div class="inline-flex items-center justify-center p-4 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 border border-emerald-500/35 text-emerald-400 rounded-2xl mb-4 shadow-lg shadow-emerald-500/5">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
      </div>
      <h1 class="text-2xl font-bold tracking-tight text-white font-sans">Solicitar Cadastro</h1>
      <p class="text-slate-400 text-sm mt-1.5 font-sans max-w-md mx-auto">Inscreva-se na infraestrutura de TI corporativa. Todo cadastro passará por aprovação prévia do administrador.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-200 text-xs flex items-start gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0 text-rose-400 mt-0.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      <div>
        <p class="font-semibold text-rose-400">Falha ao preencher cadastro</p>
        <p class="text-[11px] text-rose-350/80 mt-0.5">{{ $errors->first() }}</p>
      </div>
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
      @csrf

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nome Completo</label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Amanda Ferreira Silva" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 placeholder-slate-700 text-xs focus:outline-none focus:border-emerald-500 transition-colors" required>
        </div>
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Telefone / Ramal</label>
          <input type="text" name="contact" value="{{ old('contact') }}" oninput="applyPhoneMask(this)" placeholder="Ex: (11) 99999-9999" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 placeholder-slate-700 text-xs focus:outline-none focus:border-emerald-500 transition-colors font-mono" required>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Setor / Departamento</label>
          <select name="setor_id" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-300 text-xs focus:outline-none focus:border-emerald-500 transition-colors cursor-pointer" required>
            <option value="" disabled {{ old('setor_id') ? '' : 'selected' }}>Selecione um setor...</option>
            @foreach($setores as $setor)
              <option value="{{ $setor->id }}" {{ old('setor_id') == $setor->id ? 'selected' : '' }}>{{ $setor->nome }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Cargo / Função exercida</label>
          <select name="cargo_id" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-300 text-xs focus:outline-none focus:border-emerald-500 transition-colors cursor-pointer" required>
            <option value="" disabled {{ old('cargo_id') ? '' : 'selected' }}>Selecione um cargo...</option>
            @foreach($cargos as $cargo)
              <option value="{{ $cargo->id }}" {{ old('cargo_id') == $cargo->id ? 'selected' : '' }}>{{ $cargo->nome }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div>
        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Endereço</label>
        <input type="text" name="address" value="{{ old('address') }}" placeholder="Rua, número, bairro, cidade..." class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 placeholder-slate-700 text-xs focus:outline-none focus:border-emerald-500 transition-colors">
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">E-mail Corporativo</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="Ex: amanda.silva@empresa.com" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 placeholder-slate-700 text-xs focus:outline-none focus:border-emerald-500 transition-colors font-mono" required>
        </div>
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nível de Acesso Solicitado</label>
          <select name="profile" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-300 text-xs focus:outline-none focus:border-emerald-500 transition-colors cursor-pointer" required>
            <option value="Usuário" {{ old('profile') == 'Usuário' ? 'selected' : '' }}>Usuário Solicitante (Comum)</option>
            <option value="Técnico" {{ old('profile') == 'Técnico' ? 'selected' : '' }}>Técnico Analista (Suporte HelpDesk)</option>
            <option value="Admin" {{ old('profile') == 'Admin' ? 'selected' : '' }}>Administrador do Sistema</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Definir Senha de Acesso</label>
        <input type="password" name="password" id="reg-password" oninput="checkPasswordStrength(this.value)" placeholder="Mínimo 6 caracteres" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 placeholder-slate-700 text-xs focus:outline-none focus:border-emerald-500 transition-colors font-mono" required>
        <div class="mt-2 flex gap-1.5 items-center">
          <span class="text-[9px] font-bold text-slate-500 uppercase font-sans tracking-wide mr-1 select-none">Força:</span>
          <div class="flex-1 h-1.5 rounded-full bg-slate-900 flex gap-1 overflow-hidden">
            <div id="bar-1" class="h-full flex-1 bg-slate-800 transition-colors"></div>
            <div id="bar-2" class="h-full flex-1 bg-slate-800 transition-colors"></div>
            <div id="bar-3" class="h-full flex-1 bg-slate-800 transition-colors"></div>
          </div>
          <span id="strength-label" class="text-[10px] font-bold text-slate-600 uppercase">INCOMPLETA</span>
        </div>
      </div>

      <div class="p-3.5 bg-slate-950/45 border border-slate-850 rounded-xl space-y-3">
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Pergunta de Segurança de Resgate</label>
          <select name="question" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3 py-2 text-slate-300 text-xs focus:outline-none focus:border-emerald-500 transition-colors cursor-pointer" required>
            <option value="Qual o nome do seu primeiro animal de estimação?" {{ old('question') == 'Qual o nome do seu primeiro animal de estimação?' ? 'selected' : '' }}>Qual o nome do seu primeiro animal de estimação?</option>
            <option value="Qual a sua cidade natal?" {{ old('question') == 'Qual a sua cidade natal?' ? 'selected' : '' }}>Qual a sua cidade natal?</option>
            <option value="Qual a marca do seu primeiro carro?" {{ old('question') == 'Qual a marca do seu primeiro carro?' ? 'selected' : '' }}>Qual a marca do seu primeiro carro?</option>
            <option value="Qual o nome de solteira da sua mãe?" {{ old('question') == 'Qual o nome de solteira da sua mãe?' ? 'selected' : '' }}>Qual o nome de solteira da sua mãe?</option>
          </select>
        </div>
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Sua Resposta Confidencial</label>
          <input type="text" name="answer" value="{{ old('answer') }}" placeholder="Digite a resposta secreta para futuras recuperações" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 placeholder-slate-700 text-xs focus:outline-none focus:border-emerald-500 transition-colors" required>
        </div>
      </div>

      <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white font-medium py-3 rounded-xl transition-all shadow-lg hover:shadow-emerald-500/10 flex items-center justify-center gap-2 mt-2 relative overflow-hidden group cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-emerald-250"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg>
        <span class="font-semibold text-sm">Enviar Solicitação de Cadastro</span>
      </button>

      <div class="text-center pt-2">
        <a href="{{ route('login') }}" class="text-[11px] text-blue-400 hover:text-blue-300 font-bold uppercase tracking-wider transition-colors inline-block cursor-pointer font-semibold">
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

    bar1.className = 'h-full flex-1 bg-slate-800 transition-colors';
    bar2.className = 'h-full flex-1 bg-slate-800 transition-colors';
    bar3.className = 'h-full flex-1 bg-slate-800 transition-colors';

    if (!password) {
      label.innerText = 'INCOMPLETA';
      label.className = 'text-[10px] font-bold text-slate-650 uppercase';
      return;
    }

    if (password.length < 6) {
      bar1.className = 'h-full flex-1 bg-rose-500';
      label.innerText = 'FRACA (MÍN. 6 CAR.)';
      label.className = 'text-[10px] font-bold text-rose-450 uppercase';
      return;
    }

    const hasNumber = /\d/.test(password);
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    if (hasNumber && hasSpecial) {
      bar1.className = 'h-full flex-1 bg-emerald-500';
      bar2.className = 'h-full flex-1 bg-emerald-500';
      bar3.className = 'h-full flex-1 bg-emerald-500';
      label.innerText = 'FORTE (RECOMENDADA)';
      label.className = 'text-[10px] font-bold text-emerald-400 uppercase';
    } else if (hasNumber || hasSpecial) {
      bar1.className = 'h-full flex-1 bg-amber-500';
      bar2.className = 'h-full flex-1 bg-amber-500';
      label.innerText = 'MÉDIA';
      label.className = 'text-[10px] font-bold text-amber-400 uppercase';
    } else {
      bar1.className = 'h-full flex-1 bg-rose-500';
      label.innerText = 'FRACA';
      label.className = 'text-[10px] font-bold text-rose-400 uppercase';
    }
  }
</script>
@endpush
