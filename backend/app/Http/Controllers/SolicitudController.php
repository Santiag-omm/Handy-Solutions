<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Zona;
use App\Services\CotizacionService;
use App\Services\SolicitudService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SolicitudController extends Controller
{
    public function __construct(
        protected SolicitudService $solicitudService,
        protected CotizacionService $cotizacionService
    ) {}

    public function create(): View
    {
        $this->authorize('create', \App\Models\Solicitud::class);
        $servicios = Servicio::where('activo', true)->orderBy('orden')->get();
        $zonas = Zona::where('activo', true)->orderBy('nombre')->get();

        return view('solicitudes.create', compact('servicios', 'zonas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'servicio_id' => ['required', 'exists:servicios,id'],
            'zona_id' => ['nullable', 'exists:zonas,id'],
            'direccion' => ['required', 'string', 'max:500'],
            'descripcion_problema' => ['nullable', 'string', 'max:2000'],
            'fecha_deseada' => ['nullable', 'date', 'after_or_equal:today'],
            'urgencia' => ['required', 'in:baja,media,alta'],
            'fotos.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ]);

        $user = Auth::user();
        if (! $user) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'phone' => ['nullable', 'string', 'max:20'],
            ]);
            // Crear solicitud sin user (guest) o redirigir a login
            return redirect()->route('login')->with('message', 'Inicia sesión o regístrate para enviar tu solicitud.');
        }

        $validated['user_id'] = $user->id;

        if ($request->hasFile('fotos')) {
            $paths = [];
            foreach ($request->file('fotos') as $file) {
                $paths[] = $file->store('solicitudes/' . now()->format('Y/m/d'), 'public');
            }
            $validated['fotos'] = $paths;
        }

        $solicitud = $this->solicitudService->crearSolicitud($validated);
        $this->cotizacionService->generarAutomatica($solicitud);

        $solicitud->update(['estado' => 'cotizada']);

        $user->notify(new \App\Notifications\SolicitudRecibidaNotification($solicitud->fresh(['servicio', 'cotizacionActual'])));

        return redirect()
            ->route('solicitudes.show', $solicitud)
            ->with('success', 'Solicitud registrada. Te hemos enviado una cotización por email.');
    }

    public function show(int $id): View|RedirectResponse
    {
        $solicitud = \App\Models\Solicitud::with(['servicio', 'cotizacionActual'])->findOrFail($id);

        if (Auth::id() && $solicitud->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('solicitudes.show', compact('solicitud'));
    }
}
