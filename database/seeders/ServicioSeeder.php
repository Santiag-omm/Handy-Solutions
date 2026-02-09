<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            ['nombre' => 'Plomería', 'descripcion' => 'Reparación de tuberías, fugas, instalación de sanitarios y calentadores.', 'precio_base' => 500, 'precio_min' => 350, 'orden' => 1],
            ['nombre' => 'Electricidad', 'descripcion' => 'Instalación y reparación eléctrica, iluminación y tableros.', 'precio_base' => 450, 'precio_min' => 300, 'orden' => 2],
            ['nombre' => 'Carpintería', 'descripcion' => 'Muebles, puertas, ventanas y trabajos en madera.', 'precio_base' => 600, 'precio_min' => 400, 'orden' => 3],
            ['nombre' => 'Pintura', 'descripcion' => 'Pintura interior y exterior, acabados y texturizados.', 'precio_base' => 800, 'precio_min' => 500, 'orden' => 4],
            ['nombre' => 'Albañilería', 'descripcion' => 'Reparación de muros, pisos, aplanados y construcción menor.', 'precio_base' => 550, 'precio_min' => 380, 'orden' => 5],
            ['nombre' => 'Impermeabilización', 'descripcion' => 'Impermeabilización de azoteas, muros y terrazas.', 'precio_base' => 1200, 'precio_min' => 800, 'orden' => 6],
        ];

        foreach ($servicios as $s) {
            Servicio::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($s['nombre'])],
                array_merge($s, ['activo' => true])
            );
        }
    }
}
