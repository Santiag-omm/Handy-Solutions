<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zona extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'codigo', 'descripcion', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function tecnicos(): BelongsToMany
    {
        return $this->belongsToMany(Tecnico::class, 'tecnico_zona');
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class);
    }
}
