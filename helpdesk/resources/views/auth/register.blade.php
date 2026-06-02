<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal de Service Desk - Solicitar Registro</title>
  
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
  <div class="absolute top-20 left-10 w-96 h-96 bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>
  <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

  @php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Hash;

    // Processa o formulário quando enviado via POST
    if (request()->isMethod('POST')) {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:30',
            'sector' => 'required|string|max:100',
            'cargo' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'profile' => 'required|string|in:Usuário,Técnico,Admin',
            'password' => 'required|string|min:6',
            'question' => 'required|string',
            'answer' => 'required|string|min:2',
        ]);

        // Pega a lista de usuários da sessão (simulando o localStorage)
        $users = Session::get('helpdesk_users', []);

        // Se estiver vazia, popula com os dados padrão (mesmos do HTML original)
        if (empty($users)) {
            $users = [
                [
                    'id' => 'user-admin-1',
                    'name' => 'Mariana Souza Silva',
                    'email' => 'admin@empresa.com',
                    'profile' => 'Admin',
                    'sector' => 'Tecnologia da Informação',
                    'cargo' => 'Admin',
                    'phone' => '(11) 98888-1111',
                    'passwordHash' => Hash::make('123456'),
                    'securityQuestion' => 'Qual o nome da sua primeira escola?',
                    'securityAnswerHash' => Hash::make('objetivo'),
                    'status' => 'Ativo'
                ],
                [
                    'id' => 'user-tech-1',
                    'name' => 'Carlos Alberto Ferreira',
                    'email' => 'carlos.suporte@empresa.com',
                    'profile' => 'Técnico',
                    'sector' => 'Tecnologia da Informação',
                    'cargo' => 'Suporte Técnico',
                    'phone' => '(11) 97777-2222',
                    'passwordHash' => Hash::make('123456'),
                    'securityQuestion' => 'Qual é a sua cidade natal?',
                    'securityAnswerHash' => Hash::make('santos'),
                    'status' => 'Ativo'
                ],
                [
                    'id' => 'user-requester-1',
                    'name' => 'Juliana Silva Castro',
                    'email' => 'juliana.financeiro@empresa.com',
                    'profile' => 'Usuário',
                    'sector' => 'Financeiro / Contábil',
                    'cargo' => 'Analista Financeiro',
                    'phone' => '(11) 95555-4444',
                    'passwordHash' => Hash::make('123456'),
                    'securityQuestion' => 'Qual a marca do seu primeiro carro?',
                    'securityAnswerHash' => Hash::make('fiat'),
                    'status' => 'Ativo'
                ]
            ];
            Session::put('helpdesk_users', $users);
        }

        // Verifica se o e-mail já existe
        $exists = collect($users)->first(fn($u) => strtolower($u['email']) === strtolower($data['email']));
        if ($exists) {
            return back()->withErrors(['email' => "O e-mail {$data['email']} já possui cadastro no Service Desk (Status: {$exists['status']})."])->withInput();
        }

        // Cria novo usuário com status Pendente
        $newUser = [
            'id' => 'user-' . time(),
            'name' => $data['name'],
            'email' => $data['email'],
            'profile' => $data['profile'],
            'sector' => $data['sector'],
            'cargo' => $data['cargo'],
            'phone' => $data['contact'],
            'passwordHash' => Hash::make($data['password']),
            'securityQuestion' => $data['question'],
            'securityAnswerHash' => Hash::make(strtolower(trim($data['answer']))),
            'status' => 'Pendente'
        ];
        $users[] = $newUser;
        Session::put('helpdesk_users', $users);

        // Mensagem de sucesso e redirecionamento para login (após 4s)
        session()->flash('success_message', "Solicitação registrada com sucesso! {$data['name']} foi incluído(a) com status \"Pendente\". Redirecionando para a tela de login em 4 segundos.");
        session()->flash('redirect_login', true);
        return back();
    }

    $errorBag = session('errors');
    $successMsg = session('success_message');
    $redirectLogin = session('redirect_login');
  @endphp

  <!-- Central Box Container -->
  <div class="w-full max-w-xl flex flex-col gap-6 relative z-10 my-4">
    
    <div class="bg-slate-900/85 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl transition-all duration-300">
      
      <!-- Brand Header -->
      <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center p-4 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 border border-emerald-500/35 text-emerald-400 rounded-2xl mb-4 shadow-lg shadow-emerald-500/5">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-white font-sans">Solicitar Cadastro</h1>
        <p class="text-slate-400 text-sm mt-1.5 font-sans max-w-md mx-auto">Inscreva-se na infraestrutura de TI corporativa. Todo cadastro passará por aprovação prévia do administrador.</p>
      </div>

      <!-- Live Notification Banners (com flash do Laravel) -->
      @if($errors->any())
      <div id="error-banner" class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-200 text-xs flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0 text-rose-400 mt-0.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        <div>
          <p class="font-semibold text-rose-400">Falha ao preencher cadastro</p>
          <p id="error-message" class="text-[11px] text-rose-350/80 mt-0.5">{{ $errors->first() }}</p>
        </div>
      </div>
      @endif

      @if($successMsg)
      <div id="success-banner" class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-xs flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0 text-emerald-400 mt-0.5"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275Z"></path></svg>
        <div>
          <p class="font-semibold text-emerald-400">Solicitação Guardada</p>
          <p id="success-message" class="text-[11px] text-emerald-350/80 mt-0.5">{{ $successMsg }}</p>
        </div>
      </div>
      @if($redirectLogin)
      <script>
        setTimeout(() => { window.location.href = "{{ url('/login') }}"; }, 4000);
      </script>
      @endif
      @endif

      <!-- Registration Form -->
      <form method="POST" action="{{ url()->current() }}" class="space-y-4">
        @csrf
        
        <!-- Row 1: Nome Completo & Contato -->
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

        <!-- Row 2: Setor/Departamento & Cargo -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Setor / Departamento</label>
            <select name="sector" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-300 text-xs focus:outline-none focus:border-emerald-500 transition-colors cursor-pointer" required>
              <option value="" disabled {{ old('sector') ? '' : 'selected' }}>Selecione um setor...</option>
              <option value="Tecnologia da Informação" {{ old('sector') == 'Tecnologia da Informação' ? 'selected' : '' }}>TI / Tecnologia</option>
              <option value="Recursos Humanos" {{ old('sector') == 'Recursos Humanos' ? 'selected' : '' }}>Recursos Humanos (RH)</option>
              <option value="Financeiro / Contábil" {{ old('sector') == 'Financeiro / Contábil' ? 'selected' : '' }}>Financeiro & Faturamento</option>
              <option value="Operações / Logística" {{ old('sector') == 'Operações / Logística' ? 'selected' : '' }}>Operações & Logística</option>
              <option value="Comercial / Vendas" {{ old('sector') == 'Comercial / Vendas' ? 'selected' : '' }}>Comercial & Vendas</option>
              <option value="Suporte Técnico" {{ old('sector') == 'Suporte Técnico' ? 'selected' : '' }}>Suporte Técnico Interno</option>
              <option value="Jurídico / Compliance" {{ old('sector') == 'Jurídico / Compliance' ? 'selected' : '' }}>Jurídico & Compliance</option>
            </select>
          </div>
          <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Cargo / Função exercida</label>
            <input type="text" name="cargo" value="{{ old('cargo') }}" placeholder="Ex: Analista Financeiro Pleno" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 placeholder-slate-700 text-xs focus:outline-none focus:border-emerald-500 transition-colors" required>
          </div>
        </div>

        <!-- Row 3: Email Corporativo & Perfil Desejado -->
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

        <!-- Password and Strength Indicator -->
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

        <!-- Security Question Choice -->
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

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white font-medium py-3 rounded-xl transition-all shadow-lg hover:shadow-emerald-500/10 flex items-center justify-center gap-2 mt-2 relative overflow-hidden group cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-emerald-250"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg>
          <span class="font-semibold text-sm">Enviar Solicitação de Cadastro</span>
        </button>

        <!-- Dynamic Link to Login page -->
        <div class="text-center pt-2">
          <a href="{{ url('/login') }}" class="text-[11px] text-blue-400 hover:text-blue-300 font-bold uppercase tracking-wider transition-colors inline-block cursor-pointer font-semibold">
            ← Voltar para a Tela de Login
          </a>
        </div>

      </form>
    </div>

  </div>

  <script>
    // --- Phone contact mask (mesmo do original) ---
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

    // --- Password strength checker (mesmo do original) ---
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
</body>
</html>