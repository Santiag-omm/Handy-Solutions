<?php

namespace App\Services;

use App\Models\OrdenTrabajo;
use Illuminate\Support\Str;

class OrdenTrabajoService
{
    public function generarCodigo(): string
    {
        $prefix = 'OT';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(3));
        $number = OrdenTrabajo::withTrashed()->count() + 1;

        return $prefix . $date . '-' . str_pad((string) $number, 4, '0', STR_PAD_LEFT) . $random;
    }
}
