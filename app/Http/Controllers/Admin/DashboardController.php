<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdenTrabajo;
use App\Models\Pago;
use App\Models\Solicitud;
use App\Models\Tecnico;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalSolicitudes = Solicitud::count();
        $solicitudesPendientes = Solicitud::whereIn('estado', ['pendiente', 'validada'])->count();
        $serviciosCompletados = OrdenTrabajo::where('estado', 'completada')->count();
        $ingresos = Pago::where('estado', 'completado')->sum('monto');
        $tecnicosActivos = Tecnico::where('activo', true)->count();

        $solicitudesRecientes = Solicitud::with(['user', 'servicio'])
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalSolicitudes',
            'solicitudesPendientes',
            'serviciosCompletados',
            'ingresos',
            'tecnicosActivos',
            'solicitudesRecientes'
        ));
    }
}
