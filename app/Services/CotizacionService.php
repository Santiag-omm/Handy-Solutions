<?php

namespace App\Services;

use App\Models\Cotizacion;
use App\Models\Servicio;
use App\Models\Solicitud;

class CotizacionService
{
    /**
     * Genera cotización automática según servicio y urgencia.
     */
    public function generarAutomatica(Solicitud $solicitud): Cotizacion
    {
        $servicio = $solicitud->servicio;
        $monto = $this->calcularMontoBase($servicio, $solicitud->urgencia);

        return Cotizacion::create([
            'solicitud_id' => $solicitud->id,
            'monto' => $monto,
            'tipo' => 'automatica',
            'observaciones' => 'Cotización generada automáticamente. Sujeto a revisión in situ.',
        ]);
    }

    protected function calcularMontoBase(Servicio $servicio, string $urgencia): float
    {
        $base = (float) $servicio->precio_base;
        $min = (float) $servicio->precio_min;

        $multiplicador = match ($urgencia) {
            'alta' => 1.25,
            'media' => 1.0,
            'baja' => 0.9,
            default => 1.0,
        };

        $monto = $base * $multiplicador;

        return max($monto, $min);
    }

    public function ajustarManual(Solicitud $solicitud, float $monto, ?int $userId, ?string $observaciones = null): Cotizacion
    {
        return Cotizacion::create([
            'solicitud_id' => $solicitud->id,
            'monto' => $monto,
            'tipo' => 'manual',
            'observaciones' => $observaciones,
            'ajustado_por' => $userId,
        ]);
    }
}
