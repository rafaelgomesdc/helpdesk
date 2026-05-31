<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Session;

class VerificarPerfil
{
    public function handle(Request $request, Closure $next, ...$perfisPermitidos)
    {
        $perfilUsuario = Session::get('usuario_perfil');

        //bloquear se não tiver perfil
        //if (!$perfilUsuario){//(!in_array($perfilUsuario, $perfisPermitidos)) {
        //    abort(403, 'Acesso negado. Você não tem permissão para essa ação.');
        //}

        //if (!$perfilUsuario || $perfilUsuario !== $perfisPermitidos) {
        //    abort(403, 'Acesso negado. Você não tem permissão.');
        //}

        /*
        // Se veio uma string com vírgulas, transforma em array
        if (count($perfisPermitidos) === 1 && str_contains($perfisPermitidos[0], ',')) {
            $perfisPermitidos = explode(',', $perfisPermitidos[0]);
        }
        */
        // Verifica se o perfil do usuário está na lista de permitidos
        if (!in_array($perfilUsuario, $perfisPermitidos)) {
            abort(403, 'Acesso negado. Você não tem permissão para essa ação.');
        }
        
        return $next($request);
    }
}