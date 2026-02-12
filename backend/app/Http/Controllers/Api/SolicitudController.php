<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SolicitudController extends Controller
{
    public function userSolicitudes(Request $request)
    {
        $solicitudes = Solicitud::where('user_id', Auth::id())
            ->with('servicio')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $solicitudes
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'servicio_id' => 'required|exists:servicios,id',
            'descripcion' => 'required|string|min:10',
            'direccion' => 'required|string|min:10',
            'telefono' => 'required|string|min:8',
            'fecha_preferida' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $solicitud = Solicitud::create([
            'user_id' => Auth::id(),
            'servicio_id' => $request->servicio_id,
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'fecha_preferida' => $request->fecha_preferida,
            'estado' => 'pendiente',
        ]);

        return response()->json([
            'success' => true,
            'data' => $solicitud->load('servicio'),
            'message' => 'Solicitud creada correctamente'
        ], 201);
    }

    public function show($id)
    {
        $solicitud = Solicitud::where('user_id', Auth::id())
            ->with('servicio', 'tecnico')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $solicitud
        ]);
    }
}
