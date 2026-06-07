<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('auth.reset-password');
    }

    public function ajax(Request $request)
    {
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
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'securityQuestion' => $user->security_question,
                ],
            ]);
        }

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

        if ($request->action === 'reset') {
            $user = User::where('email', $request->email)->first();

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não encontrado.',
                ]);
            }

            $newPassword = $request->newPassword ?? '';

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

        return response()->json([
            'success' => false,
            'message' => 'Ação inválida.',
        ], 400);
    }
}
