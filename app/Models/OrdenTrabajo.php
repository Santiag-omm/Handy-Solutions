<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenTrabajo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ordenes_trabajo';

    protected $fillable = [
        'codigo', 'solicitud_id', 'tecnico_id', 'cotizacion_id', 'asignado_por',
        'fecha_asignada', 'fecha_inicio', 'fecha_fin', 'estado', 'notas_tecnico'
    ];

    protected $casts = [
        'fecha_asignada' => 'datetime',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function asignadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_por');
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'orden_trabajo_id');
    }

    public function resena(): HasOne
    {
        return $this->hasOne(Resena::class, 'orden_trabajo_id');
    }

    public function galeriaTrabajos(): HasMany
    {
        return $this->hasMany(GaleriaTrabajo::class, 'orden_trabajo_id');
    }
}
