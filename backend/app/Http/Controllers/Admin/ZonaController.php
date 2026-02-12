<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zona;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ZonaController extends Controller
{
    public function index(): View
    {
        $zonas = Zona::withCount('tecnicos')->orderBy('nombre')->paginate(15);

        return view('admin.zonas.index', compact('zonas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'codigo' => ['nullable', 'string', 'max:20', 'unique:zonas,codigo'],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['boolean'],
        ]);

        Zona::create([
            ...$validated,
            'activo' => $request->boolean('activo', true),
        ]);

        return back()->with('success', 'Zona creada.');
    }

    public function update(Request $request, Zona $zona): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'codigo' => ['nullable', 'string', 'max:20', 'unique:zonas,codigo,' . $zona->id],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['boolean'],
        ]);

        $zona->update([
            ...$validated,
            'activo' => $request->boolean('activo'),
        ]);

        return back()->with('success', 'Zona actualizada.');
    }

    public function destroy(Zona $zona): RedirectResponse
    {
        $zona->update(['activo' => false]);

        return back()->with('success', 'Zona desactivada.');
    }
}
