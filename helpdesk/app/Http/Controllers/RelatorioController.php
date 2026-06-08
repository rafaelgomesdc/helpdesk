<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function tempoMedio(Request $request)
    {
        $de         = $request->input('de');
        $ate        = $request->input('ate');
        $prioridade = $request->input('prioridade');

        $base = DB::table('tickets')->whereNotNull('resolved_at');

        if ($de) {
            $base->where('created_at', '>=', $de . ' 00:00:00');
        }
        if ($ate) {
            $base->where('created_at', '<=', $ate . ' 23:59:59');
        }
        if ($prioridade) {
            $base->where('priority', $prioridade);
        }

        $geral = (clone $base)->selectRaw('
            COUNT(*)                                              AS total,
            AVG(TIMESTAMPDIFF(MINUTE, created_at, resolved_at))  AS media_minutos,
            MIN(TIMESTAMPDIFF(MINUTE, created_at, resolved_at))  AS min_minutos,
            MAX(TIMESTAMPDIFF(MINUTE, created_at, resolved_at))  AS max_minutos
        ')->first();

        $porPrioridade = (clone $base)->selectRaw('
            priority,
            COUNT(*)                                              AS total,
            AVG(TIMESTAMPDIFF(MINUTE, created_at, resolved_at))  AS media_minutos
        ')->groupBy('priority')
          ->orderByRaw("FIELD(priority, 'critical','high','medium','low')")
          ->get()
          ->map(function ($row) {
              $row->media_formatada = $this->formatarTempo($row->media_minutos);
              return $row;
          });

        if ($geral) {
            $geral->media_formatada = $this->formatarTempo($geral->media_minutos);
            $geral->min_formatado   = $this->formatarTempo($geral->min_minutos);
            $geral->max_formatado   = $this->formatarTempo($geral->max_minutos);
        }

        $prioridades = ['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta', 'critical' => 'Crítica'];

        return view('relatorios.tempo_medio', compact(
            'geral', 'porPrioridade', 'prioridades', 'de', 'ate', 'prioridade'
        ));
    }

    private function formatarTempo(?float $minutos): string
    {
        if ($minutos === null || $minutos < 0) {
            return '—';
        }

        $min = (int) round($minutos);

        if ($min < 60) {
            return "{$min}min";
        }

        $horas = intdiv($min, 60);
        $resto  = $min % 60;

        if ($horas < 24) {
            return $resto > 0 ? "{$horas}h {$resto}min" : "{$horas}h";
        }

        $dias  = intdiv($horas, 24);
        $hRest = $horas % 24;

        return $hRest > 0 ? "{$dias}d {$hRest}h" : "{$dias}d";
    }
}
