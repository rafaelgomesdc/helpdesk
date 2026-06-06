<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'contact' => 'required|string|max:30',
            'sector' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'profile' => 'required|string|in:Usuário,Técnico,Admin',
            'question' => 'required|string|max:255',
            'answer' => 'required|string|min:2|max:255',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['contact'],
            'sector_id' => $data['sector'],
            'cargo_id' => $data['cargo'],
            'profile' => $data['profile'],
            'security_question' => $data['question'],
            'security_answer' => $data['answer'],
            'status' => 'Pendente',
        ]);

        return redirect()
            ->route('login')
            ->with('success', "Solicitação registrada com sucesso! {$data['name']} foi incluído(a) com status \"Pendente\". Aguarde aprovação do administrador.");
    }
}
