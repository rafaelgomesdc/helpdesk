<?php

// =============================================================================
//  AUTENTICAÇÃO — CADASTRO DE NOVOS USUÁRIOS
//  Responsável: Dupla 1 — Vitória e Camila
//  Módulo: Usuários e Autenticação
// =============================================================================

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\Setor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // -------------------------------------------------------------------------
    // Exibe o formulário de auto-cadastro
    // Carrega setores e cargos disponíveis para seleção pelo usuário
    // -------------------------------------------------------------------------
    public function index()
    {
        $setores = Setor::orderBy('nome')->get();
        $cargos  = Cargo::orderBy('nome')->get();

        return view('auth.register', compact('setores', 'cargos'));
    }

    // -------------------------------------------------------------------------
    // Processa o formulário de cadastro
    // O usuário é criado com status "Pendente" e aguarda aprovação do administrador
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'email_pessoal' => 'nullable|email|max:255',
            'password'      => 'required|string|min:6',
            'contact'       => 'required|string|max:30',
            'address'       => 'nullable|string|max:255',
            'setor_id'      => 'required|exists:setores,id',
            'cargo_id'      => 'required|exists:cargos,id',
            'profile'       => 'required|string|in:Usuário,Técnico',
            'question'      => 'required|string|max:255',
            'answer'        => 'required|string|min:2|max:255',
        ]);

        // Cria o usuário com status "Pendente" até aprovação manual pelo admin
        User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'email_pessoal'     => $data['email_pessoal'] ?? null,
            'password'          => Hash::make($data['password']),
            'phone'             => $data['contact'],
            'contato'           => $data['contact'],
            'address'           => $data['address'] ?? null,
            'setor_id'          => $data['setor_id'],
            'cargo_id'          => $data['cargo_id'],
            'profile'           => $data['profile'],
            'role'              => User::profileToRoleEnum($data['profile']),
            'security_question' => $data['question'],
            'security_answer'   => $data['answer'],
            'status'            => 'Pendente',
        ]);

        return redirect()
            ->route('login')
            ->with('success', "Solicitação registrada com sucesso! {$data['name']} foi incluído(a) com status \"Pendente\". Aguarde aprovação do administrador.");
    }
}
