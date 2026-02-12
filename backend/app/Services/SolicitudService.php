<?php

namespace App\Services;

use App\Models\Solicitud;
use Illuminate\Support\Str;

class SolicitudService
{
    public function generarFolio(): string
    {
        $prefix = 'SOL';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        $number = Solicitud::withTrashed()->count() + 1;

        return $prefix . $date . '-' . str_pad((string) $number, 4, '0', STR_PAD_LEFT) . $random;
    }

    public function crearSolicitud(array $data): Solicitud
    {
        $data['folio'] = $this->generarFolio();
        $data['estado'] = 'pendiente';

        return Solicitud::create($data);
    }
}
