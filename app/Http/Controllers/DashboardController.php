<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAbertos = DB::table('tickets')->where('status', 'open')->count();
        $totalAndamento = DB::table('tickets')->where('status', 'in_progress')->count();
        $totalFinalizados = DB::table('tickets')->whereIn('status', ['resolved', 'closed'])->count();

        $porCategoria = DB::table('categorias')
            ->leftJoin('tickets', 'categorias.id', '=', 'tickets.categoria_id')
            ->select('categorias.nome', DB::raw('COUNT(tickets.id) as total'))
            ->groupBy('categorias.id', 'categorias.nome')
            ->orderByDesc('total')
            ->get();

        $driver = DB::connection()->getDriverName();

        $tempoMedio = $driver === 'sqlite'
            ? DB::table('tickets')
                ->whereNotNull('resolved_at')
                ->selectRaw('AVG((julianday(resolved_at) - julianday(created_at)) * 24) as media')
                ->value('media')
            : DB::table('tickets')
                ->whereNotNull('resolved_at')
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as media')
                ->value('media');

        $tempoMedio = round($tempoMedio ?? 0, 1);

        return view('dashboard.index', compact(
            'totalAbertos',
            'totalAndamento',
            'totalFinalizados',
            'porCategoria',
            'tempoMedio'
        ));
    }
}
