<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'solicitud_id', 'monto', 'tipo', 'observaciones', 'ajustado_por'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function ajustadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ajustado_por');
    }

    public function ordenTrabajo(): HasOne
    {
        return $this->hasOne(OrdenTrabajo::class, 'cotizacion_id');
    }
}
