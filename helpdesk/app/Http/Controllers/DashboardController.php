<?php

// =============================================================================
//  DASHBOARD E INDICADORES
//  Responsável: Dupla 4 — Gabriel e Murilo
//  Módulo: Categorias, Prioridades, Dashboard e Base
// =============================================================================

namespace App\Http\Controllers;

use App\Models\Artigo;
use App\Models\Categoria;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    // -------------------------------------------------------------------------
    // Calcula as métricas principais do sistema e as agrupa para o Dashboard
    // Compatível com bancos SQLite e MySQL para cálculo de datas
    // -------------------------------------------------------------------------
    public function index()
    {
        // Métricas básicas para os cards
        $totalAbertos    = Ticket::where('status', 'open')->count();
        $totalAndamento  = Ticket::where('status', 'in_progress')->count();
        $totalFinalizados = Ticket::whereIn('status', ['resolved', 'closed'])->count();

        // Agrupamento de chamados por Categoria
        $porCategoria = Ticket::select('categoria_id', DB::raw('count(*) as total'))
            ->with('categoria')
            ->groupBy('categoria_id')
            ->get();

        // Agrupamento de chamados por Prioridade
        $byPriority = Ticket::select('priority', DB::raw('count(*) as total'))
            ->groupBy('priority')
            ->get();

        // Resumo de atividades recentes (últimas 5 ações do histórico)
        $recentActivities = TicketHistory::with(['ticket', 'user'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Cálculo de Tempo Médio de Resolução (MTTR)
        $driver = DB::connection()->getDriverName();
        $avgTime = 0;

        if ($driver === 'sqlite') {
            // Em SQLite: converte datas para Julianday, subtrai, e converte para horas (* 24)
            $avgTime = Ticket::whereNotNull('resolved_at')
                ->select(DB::raw('AVG((julianday(resolved_at) - julianday(created_at)) * 24) as avg_horas'))
                ->first()
                ->avg_horas;
        } else {
            // Em MySQL: TIMESTAMPDIFF extrai a diferença em minutos, dividido por 60 para horas
            $avgTime = Ticket::whereNotNull('resolved_at')
                ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, resolved_at)) / 60 as avg_horas'))
                ->first()
                ->avg_horas;
        }

        $tempoMedio = $avgTime ? round($avgTime, 1) : 0;

        // Métricas adicionais
        $totalUsuarios = User::where('status', 'Ativo')->count();
        $totalArtigos = Artigo::count();

        // Dados do usuário logado (com relacionamentos carregados)
        $user = User::with(['setor', 'cargo', 'accessRole'])->find(Auth::id());

        return view('dashboard.index', compact(
            'totalAbertos',
            'totalAndamento',
            'totalFinalizados',
            'porCategoria',
            'byPriority',
            'recentActivities',
            'tempoMedio',
            'totalUsuarios',
            'totalArtigos',
            'user'
        ));
    }

    // -------------------------------------------------------------------------
    // Permite que o próprio usuário logado atualize suas informações de perfil
    // -------------------------------------------------------------------------
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'phone'             => ['nullable', 'string', 'max:30'],
            'address'           => ['nullable', 'string', 'max:255'],
            'security_question' => ['nullable', 'string', 'max:255'],
            'security_answer'   => ['nullable', 'string', 'min:2', 'max:255'],
        ];

        // Se informou nova senha
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }

        $data = $request->validate($rules);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        // Se informou nova resposta secreta
        if (empty($data['security_answer'])) {
            unset($data['security_answer']);
        }

        $user->update($data);

        return redirect()->route('dashboard')
            ->with('sucesso', 'Seu perfil foi atualizado com sucesso!');
    }
}
