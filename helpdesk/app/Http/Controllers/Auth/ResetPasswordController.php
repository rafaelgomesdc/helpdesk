<?php

// =============================================================================
//  AUTENTICAÇÃO — RECUPERAÇÃO DE SENHA
//  Responsável: Dupla 1 — Vitória e Camila
//  Módulo: Usuários e Autenticação
// =============================================================================

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // -------------------------------------------------------------------------
    // Exibe a tela de recuperação de senha
    // -------------------------------------------------------------------------
    public function index()
    {
        return view('auth.reset-password');
    }

    // -------------------------------------------------------------------------
    // Ponto central de recuperação via AJAX — opera em três etapas:
    //   1. "find"   → busca o usuário pelo e-mail e retorna a pergunta de segurança
    //   2. "verify" → valida a resposta de segurança fornecida pelo usuário
    //   3. "reset"  → redefine a senha após verificação bem-sucedida
    // -------------------------------------------------------------------------
    public function ajax(Request $request)
    {
        // ------------------------------------------------------------------
        // Etapa 1: Localizar o usuário e retornar sua pergunta de segurança
        // ------------------------------------------------------------------
        if ($request->action === 'find') {
            $user = User::where('email', $request->email)->first();

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'E-mail não encontrado.',
                ]);
            }

            if (! $user->security_question) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este usuário não possui pergunta de segurança cadastrada.',
                ]);
            }

            return response()->json([
                'success' => true,
                'user'    => [
                    'name'             => $user->name,
                    'email'            => $user->email,
                    'securityQuestion' => $user->security_question,
                ],
            ]);
        }

        // ------------------------------------------------------------------
        // Etapa 2: Verificar a resposta de segurança informada
        // ------------------------------------------------------------------
        if ($request->action === 'verify') {
            $user = User::where('email', $request->email)->first();

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não encontrado.',
                ]);
            }

            if (! $user->verifySecurityAnswer($request->answer ?? '')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resposta de segurança incorreta.',
                ]);
            }

            return response()->json(['success' => true]);
        }

        // ------------------------------------------------------------------
        // Etapa 3: Redefinir a senha com a nova senha informada
        // ------------------------------------------------------------------
        if ($request->action === 'reset') {
            $user = User::where('email', $request->email)->first();

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não encontrado.',
                ]);
            }

            $newPassword = $request->newPassword ?? '';

            // A nova senha precisa ter ao menos 6 caracteres
            if (strlen($newPassword) < 6) {
                return response()->json([
                    'success' => false,
                    'message' => 'A nova senha deve ter no mínimo 6 caracteres.',
                ]);
            }

            $user->password = Hash::make($newPassword);
            $user->save();

            return response()->json(['success' => true]);
        }

        // Ação desconhecida
        return response()->json([
            'success' => false,
            'message' => 'Ação inválida.',
        ], 400);
    }
}
