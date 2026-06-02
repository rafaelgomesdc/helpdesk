<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Portal de Service Desk - Recuperar Senha</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;550;700&display=swap" rel="stylesheet">
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            mono: ['JetBrains Mono', 'monospace'],
          }
        }
      }
    }
  </script>
</head>
<body class="min-h-screen flex items-center justify-center bg-slate-950 px-4 py-12 select-none relative overflow-y-auto">

  <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f172a_1px,transparent_1px),linear-gradient(to_bottom,#0f172a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_100%,transparent_100%)] opacity-35 pointer-events-none"></div>

  <div class="absolute top-20 left-10 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
  <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="w-full max-w-xl flex flex-col gap-6 relative z-10 my-4">
    
    <div class="bg-slate-900/85 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl transition-all duration-300">
      
      <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center p-4 bg-gradient-to-br from-amber-500/20 to-orange-500/10 border border-amber-500/35 text-amber-400 rounded-2xl mb-4 shadow-lg shadow-amber-500/5">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-white font-sans">Recuperação de Senha</h1>
        <p class="text-slate-400 text-sm mt-1.5 font-sans max-w-md mx-auto">Resgate seu acesso corporativo usando perguntas secretas criptografadas.</p>
      </div>

      <div id="error-banner" class="hidden mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-200 text-xs flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0 text-rose-400 mt-0.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        <div>
          <p class="font-semibold text-rose-400">Falha no Processo</p>
          <p id="error-message" class="text-[11px] text-rose-350/80 mt-0.5"></p>
        </div>
      </div>

      <div id="success-banner" class="hidden mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-xs flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0 text-emerald-400 mt-0.5"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275Z"></path></svg>
        <div>
          <p class="font-semibold text-emerald-400">Sucesso Corporativo</p>
          <p id="success-message" class="text-[11px] text-emerald-350/80 mt-0.5"></p>
        </div>
      </div>

      <!-- STEP 1 -->
      <form id="recovery-step1" onsubmit="handleFindEmail(event)" class="space-y-4">
        <div class="space-y-1">
          <h3 class="text-sm font-bold text-white flex items-center gap-2">
            <span class="text-amber-400">01</span> Identificar Colaborador
          </h3>
          <p class="text-slate-400 text-xs">Para iniciar o restauro seguro, digite seu e-mail corporativo cadastrado.</p>
        </div>
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">E-mail Cadastrado</label>
          <input id="recovery-email-input" type="email" placeholder="ex: admin@empresa.com" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 placeholder-slate-650 text-sm focus:outline-none focus:border-blue-500 transition-colors font-mono" required>
        </div>
        <div class="flex gap-3 pt-2">
          <a href="{{ url('/login') }}" class="w-1/2 border border-slate-800 hover:bg-slate-850 text-slate-400 hover:text-slate-200 py-3 rounded-xl text-xs font-semibold uppercase tracking-wider transition-colors text-center cursor-pointer">Cancelar</a>
          <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-500 text-white py-3 rounded-xl text-xs font-semibold uppercase tracking-wider transition-all cursor-pointer">Localizar Registro</button>
        </div>
      </form>

      <!-- STEP 2 -->
      <form id="recovery-step2" onsubmit="handleVerifyAnswer(event)" class="hidden space-y-5">
        <div class="space-y-1">
          <h3 class="text-sm font-bold text-white flex items-center gap-2">
            <span class="text-amber-400">02</span> Responder Questão Secundária
          </h3>
          <p class="text-slate-400 text-xs leading-relaxed">Conta localizada: <span id="recovery-user-name" class="text-blue-400 font-semibold"></span>. Responda à questão pessoal guardada na criação de sua credencial.</p>
        </div>
        <div class="p-3.5 bg-slate-950/60 border border-slate-800 rounded-xl">
          <span class="block text-[10px] uppercase font-mono font-bold text-slate-500 tracking-wide mb-1 select-none">Questão Definida:</span>
          <span id="recovery-question-text" class="text-xs text-white font-medium italic"></span>
        </div>
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Sua Resposta</label>
          <input id="security-answer-input" type="text" placeholder="Digite a resposta confidencial..." class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-blue-500 transition-colors" required>
          <p class="text-[10px] text-slate-500 mt-2 font-mono">Dicas locais: Administrador ("objetivo"), Técnico ("santos"), Usuário Geral ("fiat").</p>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="button" onclick="backToStep1()" class="w-1/2 border border-slate-800 hover:bg-slate-850 text-slate-400 hover:text-slate-200 py-3 rounded-xl text-xs font-semibold uppercase tracking-wider transition-colors cursor-pointer">Voltar</button>
          <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-500 text-white py-3 rounded-xl text-xs font-semibold uppercase tracking-wider transition-all cursor-pointer">Confirmar Resposta</button>
        </div>
      </form>

      <!-- STEP 3 -->
      <form id="recovery-step3" onsubmit="handleResetPassword(event)" class="hidden space-y-5">
        <div class="space-y-1">
          <h3 class="text-sm font-bold text-white flex items-center gap-2">
            <span class="text-emerald-400">03</span> Gravar Credencial Nova
          </h3>
          <p class="text-slate-400 text-xs">Verificação concluída com sucesso! Redefina com segurança a sua nova chave.</p>
        </div>
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Nova Senha Corporativa</label>
          <div class="relative">
            <input id="new-password-input" type="password" placeholder="Digite ao menos 6 caracteres" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-4 pr-10 py-3 text-slate-200 placeholder-slate-650 text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all font-mono" required>
            <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3.5 top-3.5 text-slate-500 hover:text-slate-350">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
          </div>
        </div>
        <div class="flex gap-3 pt-2">
          <a href="{{ url('/login') }}" class="w-1/2 border border-slate-800 hover:bg-slate-850 text-slate-400 hover:text-slate-200 py-3 rounded-xl text-xs font-semibold uppercase tracking-wider transition-colors text-center cursor-pointer">Desistir</a>
          <button type="submit" class="w-1/2 bg-emerald-600 hover:bg-emerald-500 text-white py-3 rounded-xl text-xs font-semibold uppercase tracking-wider transition-all cursor-pointer">Salvar Nova Senha</button>
        </div>
      </form>

    </div>
  </div>

  <script>
    // --- Hashing function (compatível com o original) ---
    function calculateSimulatedHash(value) {
      if (!value) return '';
      let hash = 0;
      const clean = value.trim().toLowerCase();
      for (let i = 0; i < clean.length; i++) {
        hash = (hash << 5) - hash + clean.charCodeAt(i);
        hash |= 0;
      }
      const hex = Math.abs(hash).toString(16).padEnd(8, 'f') + "f302";
      return `sha256_${hex.padEnd(16, 'e')}_8db6a5f1debc920de0a99effe03501`;
    }

    let recoveryUser = null; // guarda temporariamente o usuário encontrado

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

    // --- Requisições AJAX para o Laravel (usando Session) ---
    async function handleFindEmail(event) {
      event.preventDefault();
      hideBanners();
      const email = document.getElementById('recovery-email-input').value.trim();
      if (!email) return showError('Informe o e-mail cadastrado.');

      const response = await fetch("/reset-password", {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ action: 'find', email })
      });
      const data = await response.json();
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
      const answer = document.getElementById('security-answer-input').value.trim().toLowerCase();
      if (!answer) return showError('Digite a resposta secreta.');

      const response = await fetch("{{ route('password.ajax') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ action: 'verify', email: recoveryUser.email, answer })
      });
      const data = await response.json();
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

      const response = await fetch("/reset-password", {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ action: 'reset', email: recoveryUser.email, newPassword })
      });
      const data = await response.json();
      if (!data.success) return showError(data.message);

      showSuccess(`Nova senha configurada com sucesso para ${recoveryUser.name}. Redirecionando para login...`);
     
     
      setTimeout(() => { window.location.href = "{{ url('/login') }}"; }, 2500);
   
   
   
    }


    
  </script>

  
</body>
</html>