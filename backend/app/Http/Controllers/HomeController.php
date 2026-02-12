<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\GaleriaTrabajo;
use App\Models\Servicio;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $servicios = Servicio::where('activo', true)->orderBy('orden')->get();
        $galeria = GaleriaTrabajo::where('visible', true)->orderBy('orden')->limit(12)->get();

        return view('home', compact('servicios', 'galeria'));
    }

    public function servicios(): View
    {
        $servicios = Servicio::where('activo', true)->orderBy('orden')->get();

        return view('servicios.index', compact('servicios'));
    }

    public function servicio(string $slug): View
    {
        $servicio = Servicio::where('slug', $slug)->where('activo', true)->firstOrFail();

        return view('servicios.show', compact('servicio'));
    }

    public function galeria(): View
    {
        $trabajos = GaleriaTrabajo::where('visible', true)->orderBy('orden')->paginate(12);

        return view('galeria', compact('trabajos'));
    }

    public function contacto(): View
    {
        return view('contacto');
    }

    public function faq(): View
    {
        $faqs = Faq::where('activo', true)->orderBy('orden')->get();

        return view('faq', compact('faqs'));
    }
}
