<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = ['tecnico_id', 'dia_semana', 'hora_inicio', 'hora_fin', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class);
    }

    public static function diasSemana(): array
    {
        return [
            0 => 'Domingo',
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
        ];
    }
}
