<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal de Service Desk - Login</title>
  
  <!-- Inter & JetBrains Mono Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;550;700&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS CDN -->
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

  <!-- Dynamic Grid Background Overlay -->
  <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f172a_1px,transparent_1px),linear-gradient(to_bottom,#0f172a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_100%,transparent_100%)] opacity-35 pointer-events-none"></div>

  <!-- Decorative ambient glowing blur blobs -->
  <div class="absolute top-20 left-10 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
  <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>

  <!-- Central Box Container -->
  <div class="w-full max-w-xl flex flex-col gap-6 relative z-10 my-4">
    
    <!-- HelpDesk Title Branding Card -->
    <div class="bg-slate-900/85 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl transition-all duration-300">
      
      <!-- Brand Header -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center p-4 bg-gradient-to-br from-blue-500/20 to-indigo-500/10 border border-blue-500/35 text-blue-400 rounded-2xl mb-4 shadow-lg shadow-blue-500/5">
          <!-- Landmark SVG Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8"><line x1="3" y1="22" x2="21" y2="22"></line><line x1="6" y1="18" x2="6" y2="11"></line><line x1="10" y1="18" x2="10" y2="11"></line><line x1="14" y1="18" x2="14" y2="11"></line><line x1="18" y1="18" x2="18" y2="11"></line><path d="m12 2-10 9h20z"></path></svg>
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-white font-sans">
          Portal de Service Desk
        </h1>
        <p class="text-slate-400 text-sm mt-1.5 font-sans max-w-md mx-auto">
          Controle de Usuários, Autenticação Organizada & Perfis de Autorização Críticos
        </p>
      </div>

      <!-- Live Notification Banners -->
      <div id="error-banner" class="hidden mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-200 text-xs flex items-start gap-3">
        <!-- ShieldAlert SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0 text-rose-400 mt-0.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        <div>
          <p id="error-title" class="font-semibold text-rose-400">Erro de Segurança</p>
          <p id="error-message" class="text-[11px] text-rose-350/80 mt-0.5">Por favor, preencha as informações necessárias.</p>
        </div>
      </div>

      <div id="success-banner" class="hidden mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-xs flex items-start gap-3">
        <!-- Sparkles SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0 text-emerald-400 mt-0.5"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275Z"></path></svg>
        <div>
          <p class="font-semibold text-emerald-400">Operação bem-sucedida</p>
          <p id="success-message" class="text-[11px] text-emerald-350/80 mt-0.5">Operação executada com sucesso.</p>
        </div>
      </div>

      <!-- STATE: Login Form -->
       
@if (session('error'))
  <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-200 text-xs">
    {{ session('error') }}
  </div>
@endif
      <form id="login-form" method="POST" action="{{ route('login.auth') }}" class="space-y-5">
    @csrf
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">
            E-mail Corporativo
          </label>
          <div class="relative">
           <input
  id="email-input"
  name="email"
  type="email"
  placeholder="ex: admin@empresa.com"
  class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-4 pr-10 py-3 text-slate-200 placeholder-slate-750 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-mono"
  required
/>
            <div class="absolute right-3.5 top-3.5 text-slate-600">
              @
            </div>
          </div>
        <div>
          <div class="flex items-center justify-between mb-2">
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">
              Senha de Segurança
            </label>
            <a
              href="{{ route('password.request') }}"
              class="text-[10px] text-blue-400 hover:text-blue-300 font-bold uppercase tracking-wider transition-colors cursor-pointer"
            >
              Esqueci a Senha ?
            </a>
          </div>
          <div class="relative">
       <input
  id="password-input"
  name="password"
  type="password"
  placeholder="••••••••"
  class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-4 pr-10 py-3 text-slate-200 placeholder-slate-700 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-mono"
  required
/>
            <button
              type="button"
              onclick="togglePasswordVisibility('password-input')"
              class="absolute right-3.5 top-3.5 text-slate-500 hover:text-slate-350"
            >
              <!-- Eye SVG -->
              <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
          </div>
        </div>

        <div class="flex items-center justify-between pt-1">
          <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
            <!-- ShieldCheck SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-emerald-500"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 11 2 2 4-4"></path></svg>
            Conexão TLS 1.3 ativa
          </div>
          <div class="text-[11px] font-mono text-slate-400">
            Tentativas falhas: <span id="failed-attempts-count" class="text-slate-500 font-bold">0</span>
          </div>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-medium py-3 rounded-xl transition-all shadow-lg hover:shadow-blue-500/10 flex items-center justify-center gap-2 mt-2 relative overflow-hidden group cursor-pointer"
        >
          <div class="absolute inset-0 w-1/2 h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-[200%] transition-transform duration-1000 ease-in-out"></div>
          <!-- KeyRound SVG -->
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-blue-250"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
          <span class="font-semibold text-sm">Validar & Entrar no Sistema</span>
        </button>

        <!-- Link to CREATE account -->
        <div class="text-center pt-2">
          <span class="text-xs text-slate-500">Novo colaborador? </span>
          <a
            href="{{ route('register.form') }}"
            class="text-[11px] text-emerald-400 hover:text-emerald-300 font-bold uppercase tracking-wider transition-colors cursor-pointer ml-1"
          >
            Solicitar Cadastro de Acesso →
          </a>
        </div>
      </form>

    </div>




  </div>

  <script>
    const DEFAULT_USERS = [
      {
        id: "user-admin-1",
        name: "Mariana Souza Silva",
        email: "admin@empresa.com",
        profile: "Admin",
        sectorId: "sec-1",
        cargoId: "car-2",
        phone: "(11) 98888-1111",
        passwordHash: "",
        securityQuestion: "Qual o nome da sua primeira escola?",
        securityAnswerHash: "",
        status: "Ativo"
      },
      {
        id: "user-tech-1",
        name: "Carlos Alberto Ferreira",
        email: "carlos.suporte@empresa.com",
        profile: "Técnico",
        sectorId: "sec-1",
        cargoId: "car-5",
        phone: "(11) 97777-2222",
        passwordHash: "",
        securityQuestion: "Qual é a sua cidade natal?",
        securityAnswerHash: "",
        status: "Ativo"
      },
      {
        id: "user-requester-1",
        name: "Juliana Silva Castro",
        email: "juliana.financeiro@empresa.com",
        profile: "Usuário",
        sectorId: "sec-3",
        cargoId: "car-6",
        phone: "(11) 95555-4444",
        passwordHash: "",
        securityQuestion: "Qual a marca do seu primeiro carro?",
        securityAnswerHash: "",
        status: "Ativo"
      }
    ];

    const SECTORS = {
      'sec-1': 'Tecnologia da Informação',
      'sec-2': 'Recursos Humanos',
      'sec-3': 'Financeiro',
      'sec-4': 'Comercial & Vendas',
      'sec-5': 'Logística',
      'sec-6': 'Atendimento ao Cliente'
    };

    const CARGOS = {
      'car-1': 'Diretor Geral',
      'car-2': 'Analista de Sistemas',
      'car-3': 'Assistente Administrativo',
      'car-4': 'Coordenador Comercial',
      'car-5': 'Técnico de Infraestrutura',
      'car-6': 'Gerente Financeiro'
    };

    let users = [];
    let failedAttempts = 0;

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

    // Load Database securely from localStorage or initialize defaults
    function initDatabase() {
      const saved = localStorage.getItem('helpdesk_users');
      if (saved) {
        users = JSON.parse(saved);
        // Ensure any old profiles without password hashes are set
        let dirty = false;
        users.forEach(u => {
          if (!u.passwordHash) {
            u.passwordHash = calculateSimulatedHash('123456');
            if (u.email.includes('admin')) u.securityAnswerHash = calculateSimulatedHash('objetivo');
            else if (u.email.includes('carlos')) u.securityAnswerHash = calculateSimulatedHash('santos');
            else u.securityAnswerHash = calculateSimulatedHash('fiat');
            dirty = true;
          }
        });
        if (dirty) saveDatabase();
      } else {
        users = DEFAULT_USERS.map(u => {
          let defaultAnswer = 'objetivo';
          if (u.email.includes('carlos')) defaultAnswer = 'santos';
          if (u.email.includes('juliana')) defaultAnswer = 'fiat';
          
          return {
            ...u,
            passwordHash: calculateSimulatedHash('123456'),
            securityAnswerHash: calculateSimulatedHash(defaultAnswer)
          };
        });
        saveDatabase();
      }
      failedAttempts = parseInt(localStorage.getItem('isolated_login_failed') || '0', 10);
      document.getElementById('failed-attempts-count').innerText = failedAttempts;

      // Auto check details from recovery
      const autoEmail = localStorage.getItem('isolated_last_recovery_email');
      if (autoEmail) {
        document.getElementById('email-input').value = autoEmail;
        localStorage.removeItem('isolated_last_recovery_email');
        showSuccessBanner("Sua senha corporativa foi alterada com sucesso! Entre agora.");
      }

      // Check if registration was recently completed
      const autoRegEmail = localStorage.getItem('isolated_last_registered_email');
      if (autoRegEmail) {
        document.getElementById('email-input').value = autoRegEmail;
        localStorage.removeItem('isolated_last_registered_email');
        showSuccessBanner(`Demanda registrada sob status "Pendente"! O Administrador TI precisará habilitar o login.`);
      }
    }

    function saveDatabase() {
      localStorage.setItem('helpdesk_users', JSON.stringify(users));
      localStorage.setItem('isolated_login_failed', failedAttempts.toString());
    }

    function togglePasswordVisibility(inputId) {
      const input = document.getElementById(inputId);
      if (input.type === 'password') {
        input.type = 'text';
      } else {
        input.type = 'password';
      }
    }

    function showErrorBanner(title, msg) {
      document.getElementById('error-title').innerText = title;
      document.getElementById('error-message').innerText = msg;
      document.getElementById('error-banner').classList.remove('hidden');
      document.getElementById('success-banner').classList.add('hidden');
    }

    function showSuccessBanner(msg) {
      document.getElementById('success-message').innerText = msg;
      document.getElementById('success-banner').classList.remove('hidden');
      document.getElementById('error-banner').classList.add('hidden');
    }

    function hideBanners() {
      document.getElementById('error-banner').classList.add('hidden');
      document.getElementById('success-banner').classList.add('hidden');
    }

    function handleLoginSubmit(event) {
      event.preventDefault();
      hideBanners();

      const email = document.getElementById('email-input').value.trim();
      const password = document.getElementById('password-input').value;

      if (!email || !password) {
        showErrorBanner('Erro de Preenchimento', 'Preencha os campos obrigatórios para autenticação segura.');
        return;
      }

      // Find user in localized DB
      const user = users.find(u => u.email.toLowerCase() === email.toLowerCase());
      if (!user) {
        showErrorBanner('Erro de Credencial', 'E-mail corporativo não localizado no Service Desk.');
        return;
      }

      // STRICT USER CONTROL: Block non-approved users
      if (user.status === 'Pendente') {
        showErrorBanner(
          'Registro Bloqueado (PENDENTE)', 
          `Sua conta registrada sob o perfil "${user.profile}" está pendente de aprovação ativa pelo Administrador corporativo. Por favor, aguarde a liberação.`
        );
        return;
      }

      if (user.status === 'Rejeitado') {
        showErrorBanner(
          'Acesso Recusado (REJEITADO)',
          `Sua solicitação de acesso foi REJEITADA pela coordenação de governança de TI. Contate o suporte para dúvidas.`
        );
        return;
      }

      if (user.status !== 'Ativo') {
        showErrorBanner('Acesso Negado', 'Sua conta não se encontra sob status operacional Ativo.');
        return;
      }

      // Cryptographic hash validation
      const typedHash = calculateSimulatedHash(password);
      if (typedHash !== user.passwordHash) {
        failedAttempts++;
        saveDatabase();
        document.getElementById('failed-attempts-count').innerText = failedAttempts;
        showErrorBanner('Falha de Autenticação', 'Sua credencial ou senha de segurança não coincide.');
        return;
      }
      
      // Store current user session details
      localStorage.setItem('helpdesk_currentUser', JSON.stringify(user));
      localStorage.setItem('isolated_logged_user', JSON.stringify(user));

      showSuccessBanner(`Acesso validado com sucesso! Iniciando módulo corporativo para ${user.name} (${user.profile}).`);

      document.getElementById('password-input').value = '';

      // Redirect depending on level of authorization access
      setTimeout(() => {
        // Redireciona para o Portal SPA de Service Desk (React)
        window.location.href = 'index.html';
      }, 1500);
    }



    window.onload = function() {
      initDatabase();
    };
  </script>
</body>
</html>
