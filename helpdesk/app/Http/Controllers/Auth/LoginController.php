<?php

// =============================================================================
//  AUTENTICAÇÃO — LOGIN DE USUÁRIOS
//  Responsável: Dupla 1 — Vitória e Camila
//  Módulo: Usuários e Autenticação
// =============================================================================

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // -------------------------------------------------------------------------
    // Exibe a tela de login
    // Redireciona para o dashboard caso o usuário já esteja autenticado
    // -------------------------------------------------------------------------
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    // -------------------------------------------------------------------------
    // Processa as credenciais enviadas pelo formulário de login
    // Verifica o status da conta antes de autenticar (Pendente / Rejeitado / Inativo)
    // -------------------------------------------------------------------------
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Conta aguardando aprovação do administrador
        if ($user && $user->status === 'Pendente') {
            return back()
                ->with('error', 'Sua conta está pendente de aprovação pelo administrador. Aguarde a liberação.')
                ->withInput();
        }

        // Conta com solicitação rejeitada pelo administrador
        if ($user && $user->status === 'Rejeitado') {
            return back()
                ->with('error', 'Sua solicitação de acesso foi rejeitada. Contate o suporte para mais informações.')
                ->withInput();
        }

        // Conta inativa por qualquer outro motivo
        if ($user && $user->status !== 'Ativo') {
            return back()
                ->with('error', 'Sua conta não está ativa. Contate o administrador.')
                ->withInput();
        }

        // Credenciais inválidas
        if (! Auth::attempt($credentials)) {
            return back()
                ->with('error', 'E-mail ou senha incorretos.')
                ->withInput();
        }

        // Regenera o token de sessão por segurança
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    // -------------------------------------------------------------------------
    // Encerra a sessão do usuário e invalida o token de segurança
    // -------------------------------------------------------------------------
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
