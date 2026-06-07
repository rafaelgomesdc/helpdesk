@extends('layouts.portal')

@section('title', 'Portal de Service Desk - Login')

@section('content')
  <div class="bg-slate-900/85 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl transition-all duration-300">

    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center p-4 bg-gradient-to-br from-blue-500/20 to-indigo-500/10 border border-blue-500/35 text-blue-400 rounded-2xl mb-4 shadow-lg shadow-blue-500/5">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8"><line x1="3" y1="22" x2="21" y2="22"></line><line x1="6" y1="18" x2="6" y2="11"></line><line x1="10" y1="18" x2="10" y2="11"></line><line x1="14" y1="18" x2="14" y2="11"></line><line x1="18" y1="18" x2="18" y2="11"></line><path d="m12 2-10 9h20z"></path></svg>
      </div>
      <h1 class="text-2xl font-bold tracking-tight text-white font-sans">Portal de Service Desk</h1>
      <p class="text-slate-400 text-sm mt-1.5 font-sans max-w-md mx-auto">
        Controle de Usuários, Autenticação Organizada & Perfis de Autorização Críticos
      </p>
    </div>

    @if (session('error'))
    <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-200 text-xs flex items-start gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0 text-rose-400 mt-0.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      <div>
        <p class="font-semibold text-rose-400">Erro de Segurança</p>
        <p class="text-[11px] text-rose-350/80 mt-0.5">{{ session('error') }}</p>
      </div>
    </div>
    @endif

    @if (session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-xs flex items-start gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0 text-emerald-400 mt-0.5"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275Z"></path></svg>
      <div>
        <p class="font-semibold text-emerald-400">Operação bem-sucedida</p>
        <p class="text-[11px] text-emerald-350/80 mt-0.5">{{ session('success') }}</p>
      </div>
    </div>
    @endif

    <form id="login-form" method="POST" action="{{ route('login.auth') }}" class="space-y-5">
      @csrf
      <div>
        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">E-mail Corporativo</label>
        <div class="relative">
          <input
            id="email-input"
            name="email"
            type="email"
            value="{{ old('email') }}"
            placeholder="ex: admin@helpdesk.com"
            class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-4 pr-10 py-3 text-slate-200 placeholder-slate-750 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-mono"
            required
          />
          <div class="absolute right-3.5 top-3.5 text-slate-600">@</div>
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between mb-2">
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Senha de Segurança</label>
          <a href="{{ route('password.request') }}" class="text-[10px] text-blue-400 hover:text-blue-300 font-bold uppercase tracking-wider transition-colors cursor-pointer">
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
          <button type="button" onclick="togglePasswordVisibility('password-input')" class="absolute right-3.5 top-3.5 text-slate-500 hover:text-slate-350">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          </button>
        </div>
      </div>

      <div class="flex items-center justify-between pt-1">
        <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-emerald-500"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 11 2 2 4-4"></path></svg>
          Conexão TLS 1.3 ativa
        </div>
      </div>

      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-medium py-3 rounded-xl transition-all shadow-lg hover:shadow-blue-500/10 flex items-center justify-center gap-2 mt-2 relative overflow-hidden group cursor-pointer">
        <div class="absolute inset-0 w-1/2 h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-[200%] transition-transform duration-1000 ease-in-out"></div>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-blue-250"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
        <span class="font-semibold text-sm">Validar & Entrar no Sistema</span>
      </button>

      <div class="text-center pt-2">
        <span class="text-xs text-slate-500">Novo colaborador? </span>
        <a href="{{ route('register.form') }}" class="text-[11px] text-emerald-400 hover:text-emerald-300 font-bold uppercase tracking-wider transition-colors cursor-pointer ml-1">
          Solicitar Cadastro de Acesso →
        </a>
      </div>
    </form>

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
