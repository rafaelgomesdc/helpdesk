<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class VerificarSessao
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('usuario_id')) {
            return redirect('/login')->with('erro', 'Você precisa estar logado para acessar essa página.');
            //return redirect()->route('login')->with('erro', 'Você precisa estar logado para acessar essa página.');
            
        }

        return $next($request);
    }
}