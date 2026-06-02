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

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'E-mail não encontrado.'
                ]);
            }

            return response()->json([
                'success' => true,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'securityQuestion' => 'Confirme para redefinir sua senha'
                ]
            ]);
        }

        if ($request->action === 'verify') {
            return response()->json(['success' => true]);
        }

        if ($request->action === 'reset') {
            $user = User::where('email', $request->email)->first();

            $user->password = Hash::make($request->newPassword);
            $user->save();

            return response()->json(['success' => true]);
        }
    }
}