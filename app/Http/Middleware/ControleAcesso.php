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
        $perfil = session('user_role');
        $usuarioLogadoId = (int) session('user_id');

        // ADMINISTRADOR -> LIBERA TUDO
        if ($perfil === 'admin') {
            return $next($request);
        }

        // TÉCNICO
        if ($perfil === 'technician') {
            // Não acessa módulos de Cargo, Setor e Categorias
            if ($request->routeIs('cargos.*') || $request->routeIs('setores.*') || $request->routeIs('categorias.*')) {
                abort(403, 'Você não tem acesso a esse módulo.');
            }

            // Não pode cadastrar nem excluir usuários
            if ($request->routeIs('users.create') || $request->routeIs('users.store') || $request->routeIs('users.destroy')) {
                abort(403, 'Ação não permitida para o seu perfil.');
            }

            // Pode editar/atualizar somente o próprio cadastro
            if ($request->routeIs('users.edit') || $request->routeIs('users.update')) {
                $paramRota = $request->route('user');
                $idNaUrl = $paramRota instanceof User ? (int) $paramRota->id : (int) $paramRota;

                if ($idNaUrl !== $usuarioLogadoId) {
                    abort(403, 'Você só pode alterar os seus próprios dados.');
                }
            }

            // FAQs e Artigos: técnico pode CRUD completo
            return $next($request);
        }

        // USUÁRIO COMUM
        if ($perfil === 'user') {
            // Bloqueia acesso a listas gerais, cargos, setores e categorias
            if ($request->routeIs('users.index') || $request->routeIs('cargos.*') || $request->routeIs('setores.*') || $request->routeIs('categorias.*')) {
                return redirect()->route('users.show', $usuarioLogadoId)
                    ->with('aviso', 'Você não tem permissão para acessar esse módulo.');
            }

            // FAQs e Artigos: somente leitura (index, show)
            if ($request->routeIs('faqs.*') || $request->routeIs('artigos.*')) {
                if (!$request->routeIs('faqs.index') && !$request->routeIs('faqs.show')
                    && !$request->routeIs('artigos.index') && !$request->routeIs('artigos.show')) {
                    abort(403, 'Você só pode visualizar FAQs e Artigos.');
                }
            }

            // Só pode ver/editar o próprio perfil
            if ($request->routeIs('users.show') || $request->routeIs('users.edit') || $request->routeIs('users.update')) {
                $paramRota = $request->route('user');
                $idNaUrl = $paramRota instanceof User ? (int) $paramRota->id : (int) $paramRota;

                if ($idNaUrl !== $usuarioLogadoId) {
                    abort(403, 'Acesso negado. Você não pode visualizar ou alterar dados de terceiros.');
                }
            }

            // Não pode excluir usuários
            if ($request->routeIs('users.destroy')) {
                abort(403, 'Ação não permitida.');
            }
        }

        return $next($request);
    }
}
