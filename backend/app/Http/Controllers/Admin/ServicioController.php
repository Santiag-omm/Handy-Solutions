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

        $validated['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('servicios', 'public');
        } else {
            unset($validated['imagen']);
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
