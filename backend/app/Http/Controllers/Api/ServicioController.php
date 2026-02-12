<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::where('activo', true)
            ->orderBy('orden')
            ->select('id', 'nombre', 'slug', 'descripcion', 'imagen', 'precio_base')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $servicios
        ]);
    }

    public function show($slug)
    {
        $servicio = Servicio::where('slug', $slug)
            ->where('activo', true)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $servicio
        ]);
    }
}
