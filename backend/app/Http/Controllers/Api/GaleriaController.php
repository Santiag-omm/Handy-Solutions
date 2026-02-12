<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GaleriaTrabajo;
use Illuminate\Http\Request;

class GaleriaController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->get('limit', 12);
        
        $galeria = GaleriaTrabajo::where('visible', true)
            ->orderBy('orden')
            ->select('id', 'titulo', 'descripcion', 'imagen', 'orden')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $galeria
        ]);
    }
}
