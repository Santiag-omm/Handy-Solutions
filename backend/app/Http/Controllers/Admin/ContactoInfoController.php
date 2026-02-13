<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactoInfo;

class ContactoInfoController extends Controller
{
    /**
     * Mostrar formulario de edición de información de contacto
     */
    public function edit()
    {
        $contactoInfo = ContactoInfo::getInfo();
        return view('admin.contacto_info.edit', compact('contactoInfo'));
    }

    /**
     * Actualizar información de contacto
     */
    public function update(Request $request)
    {
        $request->validate([
            'direccion' => 'nullable|string|max:255',
            'telefono1' => 'nullable|string|max:50',
            'telefono2' => 'nullable|string|max:50',
            'email1' => 'nullable|email|max:255',
            'email2' => 'nullable|email|max:255',
            'horario' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:255',
        ]);

        $contactoInfo = ContactoInfo::getInfo();
        $contactoInfo->update($request->all());

        return redirect()->route('admin.contacto_info.edit')
            ->with('success', 'Información de contacto actualizada correctamente.');
    }
}
