<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitud extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'solicitudes';

    protected $fillable = [
        'folio', 'user_id', 'servicio_id', 'zona_id', 'direccion',
        'descripcion_problema', 'fecha_deseada', 'urgencia', 'estado',
        'fotos', 'observaciones_admin'
    ];

    protected $casts = [
        'fecha_deseada' => 'date',
        'fotos' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }

    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class);
    }

    public function cotizacionActual(): HasOne
    {
        return $this->hasOne(Cotizacion::class)->latestOfMany();
    }

    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(OrdenTrabajo::class);
    }

    public function ordenTrabajoActual(): HasOne
    {
        return $this->hasOne(OrdenTrabajo::class)->latestOfMany();
    }
}
