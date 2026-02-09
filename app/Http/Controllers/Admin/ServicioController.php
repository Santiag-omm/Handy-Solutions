<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServicioController extends Controller
{
    public function index(): View
    {
        $servicios = Servicio::orderBy('orden')->paginate(15);

        return view('admin.servicios.index', compact('servicios'));
    }

    public function create(): View
    {
        return view('admin.servicios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio_base' => ['required', 'numeric', 'min:0'],
            'precio_min' => ['required', 'numeric', 'min:0'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'icono' => ['nullable', 'string', 'max:50'],
            'orden' => ['nullable', 'integer', 'min:0'],
            'activo' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('servicios', 'public');
        }

        Servicio::create($validated);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio creado.');
    }

    public function edit(Servicio $servicio): View
    {
        return view('admin.servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio_base' => ['required', 'numeric', 'min:0'],
            'precio_min' => ['required', 'numeric', 'min:0'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'icono' => ['nullable', 'string', 'max:50'],
            'orden' => ['nullable', 'integer', 'min:0'],
            'activo' => ['boolean'],
        ]);

        $validated['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('servicios', 'public');
        }

        $servicio->update($validated);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Servicio $servicio): RedirectResponse
    {
        $servicio->update(['activo' => false]);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio desactivado.');
    }
}
