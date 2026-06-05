<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'sector' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'profile' => 'required|string|max:50',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sector' => $request->sector,
            'cargo' => $request->cargo,
            'phone' => $request->phone,
            'profile' => $request->profile,
            'status' => 'Pendente',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Cadastro enviado! Aguarde aprovação do administrador.');
    }
}