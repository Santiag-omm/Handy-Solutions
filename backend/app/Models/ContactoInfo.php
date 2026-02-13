<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoInfo extends Model
{
    protected $fillable = [
        'direccion',
        'telefono1',
        'telefono2',
        'email1',
        'email2',
        'horario',
        'facebook',
        'instagram',
        'twitter',
        'whatsapp',
    ];

    /**
     * Obtener la información de contacto (singleton)
     */
    public static function getInfo()
    {
        return self::firstOrCreate([], [
            'direccion' => 'Calle Principal #123, Colonia Centro',
            'telefono1' => '(555) 123-4567',
            'telefono2' => '(555) 891-0123',
            'email1' => 'info@handysolutions.com',
            'email2' => 'soporte@handysolutions.com',
            'horario' => 'Lunes a Viernes: 8:00 AM - 6:00 PM',
            'facebook' => 'https://facebook.com',
            'instagram' => 'https://instagram.com',
            'twitter' => 'https://twitter.com',
            'whatsapp' => 'https://wa.me/5551234567',
        ]);
    }
}
