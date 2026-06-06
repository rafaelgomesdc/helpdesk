<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Role;
use App\Models\Setor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with(['setor', 'cargo', 'role'])->orderBy('name')->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $setores = Setor::orderBy('nome')->get();
        $cargos = Cargo::orderBy('nome')->get();
        $roles = Role::orderBy('name')->get();

        return view('usuarios.create', compact('setores', 'cargos', 'roles'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'setor_id' => ['nullable', 'exists:setores,id'],
            'cargo_id' => ['nullable', 'exists:cargos,id'],
            'profile' => ['required', 'in:Admin,Técnico,Usuário'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'status' => ['required', 'in:Ativo,Pendente,Rejeitado,Inativo'],
            'security_question' => ['nullable', 'string', 'max:255'],
            'security_answer' => ['nullable', 'string', 'min:2', 'max:255'],
        ]);

        $dados['password'] = Hash::make($dados['password']);

        User::create($dados);

        return redirect()->route('usuarios.index')
            ->with('sucesso', 'Usuário cadastrado com sucesso!');
    }

    public function show(User $usuario)
    {
        $usuario->load(['setor', 'cargo', 'role.permissions']);

        return view('usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        $setores = Setor::orderBy('nome')->get();
        $cargos = Cargo::orderBy('nome')->get();
        $roles = Role::orderBy('name')->get();

        return view('usuarios.edit', compact('usuario', 'setores', 'cargos', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$usuario->id],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'setor_id' => ['nullable', 'exists:setores,id'],
            'cargo_id' => ['nullable', 'exists:cargos,id'],
            'profile' => ['required', 'in:Admin,Técnico,Usuário'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'status' => ['required', 'in:Ativo,Pendente,Rejeitado,Inativo'],
            'security_question' => ['nullable', 'string', 'max:255'],
            'security_answer' => ['nullable', 'string', 'min:2', 'max:255'],
        ]);

        if (! empty($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        } else {
            unset($dados['password']);
        }

        if (empty($dados['security_answer'])) {
            unset($dados['security_answer']);
        }

        $usuario->update($dados);

        return redirect()->route('usuarios.show', $usuario)
            ->with('sucesso', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('erro', 'Você não pode excluir sua própria conta.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('sucesso', 'Usuário removido com sucesso!');
    }
}
