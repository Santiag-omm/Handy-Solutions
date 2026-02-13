<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacto;

class ContactoController extends Controller
{
    /**
     * Mostrar mensajes de contacto recibidos
     */
    public function index(Request $request)
    {
        $contactos = Contacto::orderBy('fecha_envio', 'desc')->paginate(10);
        
        // Estadísticas
        $stats = [
            'total' => Contacto::count(),
            'pendientes' => Contacto::pendientes()->count(),
            'leidos' => Contacto::leidos()->count(),
            'respondidos' => Contacto::respondidos()->count(),
            'hoy' => Contacto::whereDate('fecha_envio', today())->count(),
        ];
        
        return view('admin.contactos.index', compact('contactos', 'stats'));
    }

    /**
     * Mostrar detalles de un mensaje de contacto
     */
    public function show(Contacto $contacto)
    {
        // Marcar como leído si está pendiente
        if ($contacto->estado === 'pendiente') {
            $contacto->update(['estado' => 'leído']);
        }
        
        return view('admin.contactos.show', compact('contacto'));
    }

    /**
     * Actualizar estado del mensaje
     */
    public function updateEstado(Request $request, Contacto $contacto)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,leído,respondido,cerrado',
            'notas_admin' => 'nullable|string|max:1000',
        ]);

        $contacto->update([
            'estado' => $request->estado,
            'notas_admin' => $request->notas_admin,
            'fecha_respuesta' => $request->estado === 'respondido' ? now() : $contacto->fecha_respuesta,
        ]);

        return redirect()->route('admin.contactos.index')
            ->with('success', 'Mensaje actualizado correctamente.');
    }

    /**
     * Eliminar mensaje de contacto
     */
    public function destroy(Contacto $contacto)
    {
        $contacto->delete();
        
        return redirect()->route('admin.contactos.index')
            ->with('success', 'Mensaje eliminado correctamente.');
    }

    /**
     * Marcar múltiples mensajes como leídos
     */
    public function marcarLeidos(Request $request)
    {
        $ids = $request->input('ids', []);
        
        Contacto::whereIn('id', $ids)
            ->where('estado', 'pendiente')
            ->update(['estado' => 'leído']);
        
        return response()->json([
            'success' => true,
            'message' => count($ids) . ' mensajes marcados como leídos.'
        ]);
    }

    /**
     * Eliminar múltiples mensajes
     */
    public function eliminarMultiples(Request $request)
    {
        $ids = $request->input('ids', []);
        
        Contacto::whereIn('id', $ids)->delete();
        
        return response()->json([
            'success' => true,
            'message' => count($ids) . ' mensajes eliminados.'
        ]);
    }
}
