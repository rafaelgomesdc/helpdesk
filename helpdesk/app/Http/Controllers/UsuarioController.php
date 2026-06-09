<?php

// =============================================================================
//  GERENCIAMENTO DE USUÁRIOS (PAINEL ADMIN)
//  Responsável: Dupla 1 — Vitória e Camila
//  Módulo: Usuários e Autenticação
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Role;
use App\Models\Setor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // -------------------------------------------------------------------------
    // Lista todos os usuários com prioridade para os pendentes de aprovação
    // -------------------------------------------------------------------------
    public function index()
    {
        $usuarios = User::with(['setor', 'cargo', 'accessRole'])
            ->orderByRaw("CASE WHEN status = 'Pendente' THEN 0 WHEN status = 'Ativo' THEN 1 ELSE 2 END")
            ->orderBy('name')
            ->get();

        $pendentes = $usuarios->where('status', 'Pendente')->count();

        return view('usuarios.index', compact('usuarios', 'pendentes'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de cadastro de novo usuário pelo admin
    // -------------------------------------------------------------------------
    public function create()
    {
        $setores = Setor::orderBy('nome')->get();
        $cargos  = Cargo::orderBy('nome')->get();
        $roles   = Role::orderBy('name')->get();

        return view('usuarios.create', compact('setores', 'cargos', 'roles'));
    }

    // -------------------------------------------------------------------------
    // Persiste o novo usuário criado diretamente pelo administrador
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $dados = $this->validated($request);

        $dados['password'] = Hash::make($dados['password']);

        User::create($dados);

        return redirect()->route('usuarios.index')
            ->with('sucesso', 'Usuário cadastrado com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Exibe o perfil completo de um usuário (com setor, cargo e permissões)
    // -------------------------------------------------------------------------
    public function show(User $usuario)
    {
        $usuario->load(['setor', 'cargo', 'accessRole.permissions']);

        return view('usuarios.show', compact('usuario'));
    }

    // -------------------------------------------------------------------------
    // Exibe o formulário de edição de dados do usuário
    // -------------------------------------------------------------------------
    public function edit(User $usuario)
    {
        $setores = Setor::orderBy('nome')->get();
        $cargos  = Cargo::orderBy('nome')->get();
        $roles   = Role::orderBy('name')->get();

        return view('usuarios.edit', compact('usuario', 'setores', 'cargos', 'roles'));
    }

    // -------------------------------------------------------------------------
    // Atualiza os dados do usuário
    // A senha só é atualizada se uma nova for informada
    // -------------------------------------------------------------------------
    public function update(Request $request, User $usuario)
    {
        $dados = $this->validated($request, $usuario->id);

        if (! empty($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        } else {
            unset($dados['password']);
        }

        // Mantém a resposta de segurança atual se não foi alterada
        if (empty($dados['security_answer'])) {
            unset($dados['security_answer']);
        }

        $usuario->update($dados);

        return redirect()->route('usuarios.show', $usuario)
            ->with('sucesso', 'Usuário atualizado com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Aprova o cadastro de um usuário pendente, liberando o acesso ao sistema
    // -------------------------------------------------------------------------
    public function aprovar(User $usuario)
    {
        $usuario->update(['status' => 'Ativo']);

        return back()->with('sucesso', "{$usuario->name} foi aprovado(a) e já pode acessar o sistema.");
    }

    // -------------------------------------------------------------------------
    // Rejeita o cadastro de um usuário pendente
    // -------------------------------------------------------------------------
    public function rejeitar(User $usuario)
    {
        $usuario->update(['status' => 'Rejeitado']);

        return back()->with('sucesso', "Solicitação de {$usuario->name} foi rejeitada.");
    }

    // -------------------------------------------------------------------------
    // Remove permanentemente um usuário do sistema
    // O administrador não pode excluir a própria conta
    // -------------------------------------------------------------------------
    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('erro', 'Você não pode excluir sua própria conta.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('sucesso', 'Usuário removido com sucesso!');
    }

    // -------------------------------------------------------------------------
    // Centraliza as regras de validação compartilhadas entre store() e update()
    // O parâmetro $ignoreId é usado para ignorar o e-mail do próprio usuário na edição
    // -------------------------------------------------------------------------
    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $emailRule = 'required|email|unique:users,email';
        if ($ignoreId) {
            $emailRule .= ','.$ignoreId;
        }

        $rules = [
            'name'              => ['required', 'string', 'max:255'],
            'email'             => explode('|', $emailRule),
            'phone'             => ['nullable', 'string', 'max:30'],
            'address'           => ['nullable', 'string', 'max:255'],
            'setor_id'          => ['nullable', 'exists:setores,id'],
            'cargo_id'          => ['nullable', 'exists:cargos,id'],
            'profile'           => ['required', 'in:Admin,Técnico,Usuário'],
            'role_id'           => ['nullable', 'exists:roles,id'],
            'status'            => ['required', 'in:Ativo,Pendente,Rejeitado'],
            'security_question' => ['nullable', 'string', 'max:255'],
            'security_answer'   => ['nullable', 'string', 'min:2', 'max:255'],
        ];

        if ($ignoreId) {
            $rules['password'] = ['nullable', 'string', 'min:6'];
        } else {
            $rules['password'] = ['required', 'string', 'min:6'];
        }

        return $request->validate($rules);
    }
}
