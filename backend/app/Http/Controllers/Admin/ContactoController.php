<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    /**
     * Mostrar mensajes de contacto recibidos
     */
    public function index()
    {
        // Por ahora mostrar vista vacía
        // En producción aquí se listarían los mensajes de contacto recibidos
        return view('admin.contactos.index');
    }
}
