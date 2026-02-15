<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'slug', 'descripcion', 'precio_base', 'precio_min',
        'imagen', 'imagen_url', 'icono', 'orden', 'activo'
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

    /**
     * Obtener URL de la imagen (prioriza imagen_url externa)
     */
    public function getImagenUrlAttribute()
    {
        // Verificar si el campo imagen_url existe en la tabla
        if (Schema::hasColumn('servicios', 'imagen_url') && $this->imagen_url) {
            return $this->imagen_url;
        }
        
        // Si hay imagen local y existe el archivo, usarla
        if ($this->imagen && file_exists(public_path('storage/' . $this->imagen))) {
            return url('storage/' . $this->imagen);
        }
        
        // Fallback a imagen por defecto según el tipo de servicio
        return $this->getDefaultImage();
    }

    /**
     * Obtener imagen por defecto según el tipo de servicio
     */
    private function getDefaultImage()
    {
        $nombre = strtolower($this->nombre);
        
        $defaultImages = [
            'plomería' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&h=300&fit=crop&auto=format',
            'electricidad' => 'https://images.unsplash.com/photo-1581094358584-9c5e5f9a8f9b?w=400&h=300&fit=crop&auto=format',
            'carpintería' => 'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format',
            'pintura' => 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?w=400&h=300&fit=crop&auto=format',
            'albañilería' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop&auto=format',
        ];

        foreach ($defaultImages as $tipo => $url) {
            if (str_contains($nombre, $tipo)) {
                return $url;
            }
        }
        
        // Imagen por defecto genérica
        return 'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format';
    }
}
