<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Se não estiver logado, volta para o login
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('erro', 'Área restrita! Faça login primeiro.');
        }

        return $next($request);
    }
}