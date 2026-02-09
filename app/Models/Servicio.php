<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'slug', 'descripcion', 'precio_base', 'precio_min',
        'imagen', 'icono', 'orden', 'activo'
    ];

    protected $casts = [
        'precio_base' => 'decimal:2',
        'precio_min' => 'decimal:2',
        'activo' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Servicio $servicio) {
            if (empty($servicio->slug)) {
                $servicio->slug = Str::slug($servicio->nombre);
            }
        });
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class);
    }

    public function galeriaTrabajos(): HasMany
    {
        return $this->hasMany(GaleriaTrabajo::class, 'servicio_id');
    }
}
