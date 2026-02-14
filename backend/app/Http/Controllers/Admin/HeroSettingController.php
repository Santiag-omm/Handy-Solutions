<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSetting;

class HeroSettingController extends Controller
{
    /**
     * Mostrar formulario de edición del hero
     */
    public function edit()
    {
        $heroSettings = HeroSetting::getSettings();
        return view('admin.hero_settings.edit', compact('heroSettings'));
    }

    /**
     * Actualizar configuración del hero
     */
    public function update(Request $request)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'subtitulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'imagen_fondo' => 'nullable|url|max:500',
            'texto_boton' => 'nullable|string|max:50',
            'enlace_boton' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ]);

        $heroSettings = HeroSetting::getSettings();
        $heroSettings->update($request->all());

        return redirect()->route('admin.hero_settings.edit')
            ->with('success', 'Configuración del hero actualizada correctamente.');
    }
}
