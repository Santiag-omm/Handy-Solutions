<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSetting extends Model
{
    protected $table = 'hero_settings';
    
    protected $fillable = [
        'titulo',
        'subtitulo',
        'descripcion',
        'imagen_fondo',
        'texto_boton',
        'enlace_boton',
        'activo',
    ];

    /**
     * Obtener la configuración del hero (singleton)
     */
    public static function getSettings()
    {
        return self::firstOrCreate([], [
            'titulo' => 'Servicios Profesionales de Mantenimiento',
            'subtitulo' => 'Soluciones rápidas y confiables para tu hogar y negocio',
            'descripcion' => 'Contamos con técnicos certificados y herramientas modernas para resolver cualquier problema de plomería, electricidad y más.',
            'imagen_fondo' => 'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=1200&h=600&fit=crop&auto=format',
            'texto_boton' => 'Solicitar Servicio',
            'enlace_boton' => '#/solicitar-servicio',
            'activo' => true,
        ]);
    }
}
