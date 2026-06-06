<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->status === 'Pendente') {
            return back()
                ->with('error', 'Sua conta está pendente de aprovação pelo administrador. Aguarde a liberação.')
                ->withInput();
        }

        if ($user && $user->status === 'Rejeitado') {
            return back()
                ->with('error', 'Sua solicitação de acesso foi rejeitada. Contate o suporte para mais informações.')
                ->withInput();
        }

        if ($user && $user->status !== 'Ativo') {
            return back()
                ->with('error', 'Sua conta não está ativa. Contate o administrador.')
                ->withInput();
        }

        if (! Auth::attempt($credentials)) {
            return back()
                ->with('error', 'E-mail ou senha incorretos.')
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
