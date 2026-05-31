<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ControleAcesso
{
    public function handle(Request $request, Closure $next): Response
    {
        $perfil = session('user_role'); // admin, technician, user
        $usuarioLogadoId = (int) session('user_id'); // ID do usuário logado (FORÇADO COMO INTEIRO)

        //  ADMINISTRADOR -> LIBERA TUDO
        if ($perfil === 'admin') {
            return $next($request);
        }

        //  TÉCNICO
        if ($perfil === 'technician') {
            //  NÃO acessa módulos de Cargo e Setor
            if ($request->routeIs('cargos.*') || $request->routeIs('setores.*')) {
                abort(403, 'Você não tem acesso a esse módulo.');
            }

            //  NÃO pode CADASTRAR nem EXCLUIR ninguém
            if ($request->routeIs('*.create') || $request->routeIs('*.store') || $request->routeIs('*.destroy')) {
                abort(403, 'Ação não permitida para o seu perfil.');
            }

            //  PODE EDITAR/ATUALIZAR -> SOMENTE SE FOR O PRÓPRIO CADASTRO
            if ($request->routeIs('users.edit') || $request->routeIs('users.update')) {
                
                //  Pegamos o ID do objeto se for um User, ou o valor direto
                $paramRota = $request->route('user');
                $idNaUrl = $paramRota instanceof User ? (int)$paramRota->id : (int)$paramRota;

                // Se tentar editar ID diferente do DELE -> BLOQUEIA
                if ($idNaUrl !== $usuarioLogadoId) {
                    abort(403, 'Você só pode alterar os seus próprios dados.');
                }
            }
        }

        //  USUÁRIO COMUM
        if ($perfil === 'user') {
            
            //  BLOQUEIA acesso a listas gerais, cargos e setores
            if ($request->routeIs('users.index') || $request->routeIs('cargos.*') || $request->routeIs('setores.*')) {
                // 🚀 AO TENTAR ACESSAR A LISTA, REDIRECIONA PARA SEU PERFIL AO INVÉS DE DAR ERRO
                return redirect()->route('users.show', $usuarioLogadoId)->with('aviso', 'Você só tem acesso aos seus próprios dados.');
            }

            //  SÓ pode ver/editar o SEU perfil
            if ($request->routeIs('users.show') || $request->routeIs('users.edit') || $request->routeIs('users.update')) {
                
                //  Pegamos o ID do objeto se for um User, ou o valor direto
                $paramRota = $request->route('user');
                $idNaUrl = $paramRota instanceof User ? (int)$paramRota->id : (int)$paramRota;

                // Se tentar ver ou editar ID diferente do SEU -> Bloqueia
                if ($idNaUrl !== $usuarioLogadoId) {
                    abort(403, 'Acesso negado. Você não pode visualizar ou alterar dados de terceiros.');
                }
            }

            //  NÃO pode excluir
            if ($request->routeIs('users.destroy')) {
                abort(403, 'Ação não permitida.');
            }
        }

        return $next($request);
    }
}