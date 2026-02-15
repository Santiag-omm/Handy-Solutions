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
    public function index(Request $request): View
    {
        $servicios = Servicio::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->paginate(15);

        return view('admin.servicios.index', compact('servicios'));
    }

    public function create()
    {
        try {
            return view('admin.servicios.create');
        } catch (\Exception $e) {
            return redirect()->route('admin.servicios.index')
                ->with('error', 'Error al cargar formulario de creación: ' . $e->getMessage());
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio_base' => ['required', 'numeric', 'min:0'],
            'precio_min' => ['required', 'numeric', 'min:0'],
            'imagen' => [
                'nullable',
                'file',
                'max:10240',
                function (string $attribute, mixed $value, \Closure $fail) {
                    if (! $value) {
                        return;
                    }

                    $mime = $value->getMimeType();
                    if (! $mime || ! str_starts_with($mime, 'image/')) {
                        $fail('The ' . $attribute . ' field must be an image.');
                        return;
                    }

                    $skipImageSizeCheckMimes = [
                        'image/svg+xml',
                        'image/avif',
                        'image/heic',
                        'image/heif',
                    ];

                    if (! in_array($mime, $skipImageSizeCheckMimes, true)) {
                        $path = $value->getRealPath();
                        if (! $path || @getimagesize($path) === false) {
                            $fail('The ' . $attribute . ' field must be an image.');
                        }
                    }
                },
            ],
            'icono' => ['nullable', 'string', 'max:50'],
            'orden' => ['nullable', 'integer', 'min:0'],
            'activo' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('servicios', 'public');
        }

        // Manejar URL externa de imagen
        if ($request->filled('imagen_url')) {
            $validated['imagen_url'] = $request->imagen_url;
        }

        Servicio::create($validated);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio creado.');
    }

    public function edit(Servicio $servicio)
    {
        try {
            return view('admin.servicios.edit', compact('servicio'));
        } catch (\Exception $e) {
            // Si hay un error, redirigir con mensaje
            return redirect()->route('admin.servicios.index')
                ->with('error', 'Error al cargar el servicio: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Servicio $servicio): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio_base' => ['required', 'numeric', 'min:0'],
            'precio_min' => ['required', 'numeric', 'min:0'],
            'imagen' => [
                'nullable',
                'file',
                'max:10240',
                function (string $attribute, mixed $value, \Closure $fail) {
                    if (! $value) {
                        return;
                    }

                    $mime = $value->getMimeType();
                    if (! $mime || ! str_starts_with($mime, 'image/')) {
                        $fail('The ' . $attribute . ' field must be an image.');
                        return;
                    }

                    $skipImageSizeCheckMimes = [
                        'image/svg+xml',
                        'image/avif',
                        'image/heic',
                        'image/heif',
                    ];

                    if (! in_array($mime, $skipImageSizeCheckMimes, true)) {
                        $path = $value->getRealPath();
                        if (! $path || @getimagesize($path) === false) {
                            $fail('The ' . $attribute . ' field must be an image.');
                        }
                    }
                },
            ],
            'icono' => ['nullable', 'string', 'max:50'],
            'imagen_url' => ['nullable', 'url', 'max:500'],
            'orden' => ['nullable', 'integer', 'min:0'],
            'activo' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('servicios', 'public');
        } else {
            unset($validated['imagen']);
        }

        // Manejar URL externa de imagen
        if ($request->filled('imagen_url')) {
            $validated['imagen_url'] = $request->imagen_url;
        } elseif (!$request->hasFile('imagen')) {
            // Si no hay nueva imagen ni URL, mantener la existente
            unset($validated['imagen_url']);
        }

        $servicio->update($validated);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Servicio $servicio): RedirectResponse
    {
        if ($servicio->solicitudes()->exists()) {
            $servicio->update(['activo' => false]);

            return redirect()
                ->route('admin.servicios.index')
                ->with('error', 'El servicio tiene solicitudes asociadas. Se desactivó en lugar de eliminarse.');
        }

        $servicio->delete();

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio eliminado.');
    }
}
