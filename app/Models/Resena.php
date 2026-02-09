<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resena extends Model
{
    use HasFactory;

    protected $table = 'resenas';

    protected $fillable = ['orden_trabajo_id', 'user_id', 'calificacion', 'comentario', 'visible'];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function ordenTrabajo(): BelongsTo
    {
        return $this->belongsTo(OrdenTrabajo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
