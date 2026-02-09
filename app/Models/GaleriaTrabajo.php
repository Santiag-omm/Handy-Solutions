<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriaTrabajo extends Model
{
    use HasFactory;

    protected $table = 'galeria_trabajos';

    protected $fillable = [
        'orden_trabajo_id', 'imagen', 'titulo', 'descripcion',
        'servicio_id', 'orden', 'destacado', 'visible'
    ];

    protected $casts = [
        'destacado' => 'boolean',
        'visible' => 'boolean',
    ];

    public function ordenTrabajo(): BelongsTo
    {
        return $this->belongsTo(OrdenTrabajo::class);
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }
}
