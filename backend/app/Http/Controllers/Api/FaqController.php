<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('activo', true)
            ->orderBy('orden')
            ->select('id', 'pregunta', 'respuesta', 'orden')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $faqs
        ]);
    }
}
