<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tecnico extends Model
{
    use HasFactory;

    protected $table = 'tecnicos';

    protected $fillable = [
        'user_id', 'especialidades', 'calificacion_promedio',
        'total_servicios', 'activo'
    ];

    protected $casts = [
        'calificacion_promedio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zonas(): BelongsToMany
    {
        return $this->belongsToMany(Zona::class, 'tecnico_zona');
    }

    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(OrdenTrabajo::class, 'tecnico_id');
    }

    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class, 'tecnico_id');
    }
}
