<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Tela de Login
    public function login()
    {
        return view('auth.login');
    }

    // Processar Login
    public function autenticar(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email',
            'senha' => 'required'
        ]);

        $usuario = Usuario::where('email', $dados['email'])->first();

        if ($usuario && Hash::check($dados['senha'], $usuario->senha)) {
            
            // 🔹 SALVANDO DADOS NA SESSÃO (FORMATO CORRETO)
            Session::put('usuario_id', $usuario->id);
            Session::put('usuario_nome', $usuario->nome);
            //Session::put('usuario_perfil', $usuario->perfil);
            Session::put('usuario_perfil', $usuario->perfil->nome);

            return redirect()->route('dashboard');
        }

        return back()->with('erro', 'E-mail ou senha inválidos.');
    }

    // Tela Principal / Dashboard
    public function dashboard()
    {
        // 🔹 VERIFICAÇÃO DE SEGURANÇA SIMPLES
        if (!Session::has('usuario_id')) {
            return redirect()->route('login');
        }
        
        return view('dashboard');
    }

    // Logout
    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}