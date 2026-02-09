<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdenTrabajo;
use App\Models\Pago;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PagoController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'orden_trabajo_id' => ['required', 'exists:ordenes_trabajo,id'],
            'monto' => ['required', 'numeric', 'min:0'],
            'metodo' => ['required', 'in:efectivo,transferencia,tarjeta,otro'],
            'referencia' => ['nullable', 'string', 'max:100'],
        ]);

        Pago::create([
            ...$validated,
            'estado' => 'completado',
            'fecha_pago' => now(),
        ]);

        return back()->with('success', 'Pago registrado.');
    }
}
