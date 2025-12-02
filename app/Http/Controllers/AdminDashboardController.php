<?php

namespace App\Http\Controllers;

use App\Models\Ganado;
use App\Models\Maquinaria;
use App\Models\Organico;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalGanado       = Ganado::count();
        $totalMaquinaria   = Maquinaria::count();
        $totalOrganicos    = Organico::count();
        $totalPublicaciones = $totalGanado + $totalMaquinaria + $totalOrganicos;

        $hoy          = Carbon::today();
        $inicioSemana = Carbon::now()->startOfWeek();
        $inicioMes    = Carbon::now()->startOfMonth();

        $hoyGanado     = Ganado::whereDate('created_at', $hoy)->count();
        $hoyMaquinaria = Maquinaria::whereDate('created_at', $hoy)->count();
        $hoyOrganicos  = Organico::whereDate('created_at', $hoy)->count();
        $totalHoy      = $hoyGanado + $hoyMaquinaria + $hoyOrganicos;

        $semGanado     = Ganado::whereBetween('created_at', [$inicioSemana, now()])->count();
        $semMaquinaria = Maquinaria::whereBetween('created_at', [$inicioSemana, now()])->count();
        $semOrganicos  = Organico::whereBetween('created_at', [$inicioSemana, now()])->count();
        $totalSemana   = $semGanado + $semMaquinaria + $semOrganicos;

        $mesGanado     = Ganado::whereBetween('created_at', [$inicioMes, now()])->count();
        $mesMaquinaria = Maquinaria::whereBetween('created_at', [$inicioMes, now()])->count();
        $mesOrganicos  = Organico::whereBetween('created_at', [$inicioMes, now()])->count();
        $totalMes      = $mesGanado + $mesMaquinaria + $mesOrganicos;

        if ($totalPublicaciones > 0) {
            $porcentajeGanado     = round(($totalGanado / $totalPublicaciones) * 100, 1);
            $porcentajeMaquinaria = round(($totalMaquinaria / $totalPublicaciones) * 100, 1);
            $porcentajeOrganicos  = round(($totalOrganicos / $totalPublicaciones) * 100, 1);
        } else {
            $porcentajeGanado = $porcentajeMaquinaria = $porcentajeOrganicos = 0;
        }

        $labelsMeses      = [];
        $ganadoPorMes     = [];
        $maquinariaPorMes = [];
        $organicosPorMes  = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha     = Carbon::now()->subMonths($i);
            $inicioMesX = $fecha->copy()->startOfMonth();
            $finMesX    = $fecha->copy()->endOfMonth();

            $labelsMeses[]      = ucfirst($fecha->translatedFormat('M'));
            $ganadoPorMes[]     = Ganado::whereBetween('created_at', [$inicioMesX, $finMesX])->count();
            $maquinariaPorMes[] = Maquinaria::whereBetween('created_at', [$inicioMesX, $finMesX])->count();
            $organicosPorMes[]  = Organico::whereBetween('created_at', [$inicioMesX, $finMesX])->count();
        }

        return view('admin.dashboard', [
            // Totales generales
            'totalGanado'        => $totalGanado,
            'totalMaquinaria'    => $totalMaquinaria,
            'totalOrganicos'     => $totalOrganicos,
            'totalPublicaciones' => $totalPublicaciones,

            // Actividad reciente
            'totalHoy'           => $totalHoy,
            'totalSemana'        => $totalSemana,
            'totalMes'           => $totalMes,

            // Porcentajes
            'porcentajeGanado'     => $porcentajeGanado,
            'porcentajeMaquinaria' => $porcentajeMaquinaria,
            'porcentajeOrganicos'  => $porcentajeOrganicos,

            // Gráficos por mes
            'labelsMeses'        => $labelsMeses,
            'ganadoPorMes'       => $ganadoPorMes,
            'maquinariaPorMes'   => $maquinariaPorMes,
            'organicosPorMes'    => $organicosPorMes,
        ]);
    }
}
