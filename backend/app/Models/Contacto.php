<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'asunto',
        'mensaje',
        'estado',
        'notas_admin',
        'fecha_envio',
        'fecha_respuesta',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
        'fecha_respuesta' => 'datetime',
    ];

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeLeidos($query)
    {
        return $query->where('estado', 'leído');
    }

    public function scopeRespondidos($query)
    {
        return $query->where('estado', 'respondido');
    }

    public function scopeCerrados($query)
    {
        return $query->where('estado', 'cerrado');
    }
}
