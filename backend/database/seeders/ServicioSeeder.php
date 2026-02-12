<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

            ['nombre' => 'Remodelación de baño', 'descripcion' => 'Restroom remodeling: remodelación completa, acabados y mejoras.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 10],
            ['nombre' => 'Instalación de tina/regadera', 'descripcion' => 'Tub/Shower combo installation: instalación y reemplazo de combinaciones tina/regadera.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 11],
            ['nombre' => 'Ampliación de baño', 'descripcion' => 'Bathroom extensions: ampliaciones y adecuaciones de espacios.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 12],

            ['nombre' => 'Reparación de techo', 'descripcion' => 'Roof repair: reparación general y mantenimiento preventivo.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 20],
            ['nombre' => 'Reparación de fugas en techo', 'descripcion' => 'Roof leak repairs: diagnóstico y reparación de filtraciones.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 21],
            ['nombre' => 'Renovación de techo', 'descripcion' => 'Roof renovation: renovación de secciones dañadas y mejora de protección.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 22],

            ['nombre' => 'Instalación de grifos', 'descripcion' => 'Faucet installation: instalación de grifería y accesorios.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 30],
            ['nombre' => 'Reemplazo de grifos', 'descripcion' => 'Faucet replacement: retiro y sustitución de grifería.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 31],

            ['nombre' => 'Igualación de textura', 'descripcion' => 'Texture matching: igualación de textura en muros y plafones.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 40],
            ['nombre' => 'Reparación de drywall', 'descripcion' => 'Drywall repair: reparación general, resanes y acabados.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 41],

            ['nombre' => 'Instalación de iluminación', 'descripcion' => 'Lighting fixtures: instalación y reemplazo de luminarias.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 50],
            ['nombre' => 'Iluminación empotrada', 'descripcion' => 'Recessed lighting: instalación de luces empotradas.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 51],
            ['nombre' => 'Reemplazo de ventilador', 'descripcion' => 'Fan replacement: instalación y reemplazo de ventiladores de techo.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 52],

            ['nombre' => 'Pintura interior/exterior', 'descripcion' => 'Interior/Exterior painting: pintura general interior y exterior.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 60],

            ['nombre' => 'Instalación de pisos', 'descripcion' => 'Flooring installation: instalación de tile, vinyl, laminate, etc.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 70],
            ['nombre' => 'Reemplazo de piso', 'descripcion' => 'Floor replacement: reemplazo y reparación de pisos.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 71],

            ['nombre' => 'Remodelación de cocina', 'descripcion' => 'Kitchen remodel: remodelación y mejoras en cocina.', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 80],
            ['nombre' => 'Power wash', 'descripcion' => 'Power wash: lavado a presión (driveway, house, etc.).', 'precio_base' => 0, 'precio_min' => 0, 'orden' => 81],
        ];

        foreach ($servicios as $s) {
            Servicio::firstOrCreate(
                ['slug' => Str::slug($s['nombre'])],
                array_merge($s, ['activo' => true])
            );
        }
    }
}
