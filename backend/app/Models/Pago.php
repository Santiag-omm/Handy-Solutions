<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'orden_trabajo_id', 'monto', 'metodo', 'estado',
        'referencia', 'fecha_pago'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'datetime',
    ];

    public function ordenTrabajo(): BelongsTo
    {
        return $this->belongsTo(OrdenTrabajo::class);
    }
}
