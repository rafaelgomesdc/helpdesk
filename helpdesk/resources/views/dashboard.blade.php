@extends('layouts.portal')

@section('title', 'Portal de Service Desk - Dashboard')

@section('width', 'max-w-xl')

@section('content')
  <div class="bg-slate-900/85 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl transition-all duration-300">

    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center p-4 bg-gradient-to-br from-blue-500/20 to-indigo-500/10 border border-blue-500/35 text-blue-400 rounded-2xl mb-4 shadow-lg shadow-blue-500/5">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8"><line x1="3" y1="22" x2="21" y2="22"></line><line x1="6" y1="18" x2="6" y2="11"></line><line x1="10" y1="18" x2="10" y2="11"></line><line x1="14" y1="18" x2="14" y2="11"></line><line x1="18" y1="18" x2="18" y2="11"></line><path d="m12 2-10 9h20z"></path></svg>
      </div>
      <h1 class="text-2xl font-bold tracking-tight text-white font-sans">Portal de Service Desk</h1>
      <p class="text-slate-400 text-sm mt-1.5 font-sans max-w-md mx-auto">
        Sessão autenticada com sucesso no ambiente corporativo
      </p>
    </div>

    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-xs flex items-start gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 flex-shrink-0 text-emerald-400 mt-0.5"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275Z"></path></svg>
      <div>
        <p class="font-semibold text-emerald-400">Acesso autorizado</p>
        <p class="text-[11px] text-emerald-350/80 mt-0.5">
          Bem-vindo(a), <span class="font-semibold text-white">{{ auth()->user()->name }}</span>.
          Perfil <span class="font-mono">{{ auth()->user()->profile }}</span> ativo no sistema.
        </p>
      </div>
    </div>

    <div class="space-y-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800">
          <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Status</p>
          <p class="text-sm font-semibold text-emerald-400">{{ auth()->user()->status }}</p>
        </div>
        <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800">
          <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Telefone</p>
          <p class="text-sm font-mono text-slate-300">{{ auth()->user()->phone ?? '—' }}</p>
        </div>
      </div>

      <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800">
        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">E-mail Corporativo</p>
        <p class="text-sm font-mono text-slate-300">{{ auth()->user()->email }}</p>
      </div>

      <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800">
        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Setor / Cargo</p>
        <p class="text-sm text-slate-300">{{ auth()->user()->sector_id ?? '—' }} · {{ auth()->user()->cargo_id ?? '—' }}</p>
      </div>

      <div class="flex items-center justify-between pt-1">
        <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-emerald-500"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 11 2 2 4-4"></path></svg>
          Sessão segura ativa
        </div>
        <div class="text-[11px] font-mono text-slate-500">
          ID #{{ auth()->user()->id }}
        </div>
      </div>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-200 font-medium py-3 rounded-xl transition-all flex items-center justify-center gap-2 mt-2 cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
          <span class="font-semibold text-sm">Encerrar Sessão</span>
        </button>
      </form>
    </div>

  </div>
@endsection
