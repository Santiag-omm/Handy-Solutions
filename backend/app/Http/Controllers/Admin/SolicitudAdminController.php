<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use App\Services\CotizacionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SolicitudAdminController extends Controller
{
    public function __construct(
        protected CotizacionService $cotizacionService
    ) {}

    public function index(Request $request): View
    {
        $query = Solicitud::with(['user', 'servicio', 'zona', 'cotizacionActual']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('servicio_id')) {
            $query->where('servicio_id', $request->servicio_id);
        }

        $solicitudes = $query->latest()->paginate(15)->withQueryString();

        return view('admin.solicitudes.index', compact('solicitudes'));
    }

    public function show(Solicitud $solicitud): View
    {
        $solicitud->load(['user', 'servicio', 'zona', 'cotizaciones', 'ordenTrabajoActual.tecnico.user']);

        return view('admin.solicitudes.show', compact('solicitud'));
    }

    public function validar(Solicitud $solicitud): RedirectResponse
    {
        $solicitud->update(['estado' => 'validada']);

        return back()->with('success', 'Solicitud validada.');
    }

    public function rechazar(Request $request, Solicitud $solicitud): RedirectResponse
    {
        $request->validate(['observaciones_admin' => ['nullable', 'string', 'max:500']]);
        $solicitud->update([
            'estado' => 'rechazada',
            'observaciones_admin' => $request->observaciones_admin,
        ]);

        return back()->with('success', 'Solicitud rechazada.');
    }

    public function cotizar(Request $request, Solicitud $solicitud): RedirectResponse
    {
        $validated = $request->validate([
            'monto' => ['required', 'numeric', 'min:0'],
            'observaciones' => ['nullable', 'string', 'max:500'],
        ]);

        $this->cotizacionService->ajustarManual(
            $solicitud,
            (float) $validated['monto'],
            auth()->id(),
            $validated['observaciones'] ?? null
        );
        $solicitud->update(['estado' => 'cotizada']);

        return back()->with('success', 'Cotización actualizada.');
    }
}
