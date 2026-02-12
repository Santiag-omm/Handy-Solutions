<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdenTrabajo;
use App\Models\Solicitud;
use App\Models\Tecnico;
use App\Services\OrdenTrabajoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrdenTrabajoController extends Controller
{
    public function __construct(
        protected OrdenTrabajoService $ordenService
    ) {}

    public function index(Request $request): View
    {
        $query = OrdenTrabajo::with(['solicitud.user', 'solicitud.servicio', 'tecnico.user']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $ordenes = $query->latest()->paginate(15)->withQueryString();

        return view('admin.ordenes.index', compact('ordenes'));
    }

    public function create(Solicitud $solicitud): View
    {
        $solicitud->load('cotizacionActual');
        $tecnicos = Tecnico::with('user')->where('activo', true)->get();

        return view('admin.ordenes.create', compact('solicitud', 'tecnicos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'solicitud_id' => ['required', 'exists:solicitudes,id'],
            'tecnico_id' => ['required', 'exists:tecnicos,id'],
            'cotizacion_id' => ['nullable', 'exists:cotizaciones,id'],
            'fecha_asignada' => ['nullable', 'date'],
        ]);

        $solicitud = Solicitud::findOrFail($validated['solicitud_id']);

        $orden = OrdenTrabajo::create([
            'codigo' => $this->ordenService->generarCodigo(),
            'solicitud_id' => $solicitud->id,
            'tecnico_id' => $validated['tecnico_id'],
            'cotizacion_id' => $validated['cotizacion_id'] ?? $solicitud->cotizacionActual?->id,
            'asignado_por' => auth()->id(),
            'fecha_asignada' => $validated['fecha_asignada'] ?? now(),
            'estado' => 'asignada',
        ]);

        $solicitud->update(['estado' => 'asignada']);

        $solicitud->user->notify(new \App\Notifications\TecnicoAsignadoNotification($orden->load('tecnico.user')));

        return redirect()
            ->route('admin.ordenes.show', $orden)
            ->with('success', 'Orden de trabajo creada. Técnico asignado.');
    }

    public function show(OrdenTrabajo $orden): View
    {
        $orden->load([
            'solicitud.user', 'solicitud.servicio', 'solicitud.cotizacionActual',
            'tecnico.user', 'pagos', 'resena',
        ]);

        return view('admin.ordenes.show', compact('orden'));
    }

    public function updateEstado(Request $request, OrdenTrabajo $orden): RedirectResponse
    {
        $request->validate(['estado' => ['required', 'in:asignada,en_camino,en_proceso,completada,cancelada']]);

        $orden->update(['estado' => $request->estado]);

        if ($request->estado === 'completada') {
            $orden->solicitud->update(['estado' => 'completada']);
            $orden->solicitud->user->notify(new \App\Notifications\ServicioCompletadoNotification($orden));
        }

        return back()->with('success', 'Estado actualizado.');
    }
}
