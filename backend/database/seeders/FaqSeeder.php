<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // Solo ejecutar si la tabla está completamente vacía (primera instalación)
        if (Faq::count() > 0) {
            $this->command->info('La tabla de FAQs ya contiene datos. Omitiendo seeder.');
            return;
        }

        $faqs = [
            ['pregunta' => '¿Cómo solicito un servicio?', 'respuesta' => 'Regístrate o inicia sesión, ve a "Solicitar servicio", completa el formulario con el tipo de servicio, dirección y descripción. Recibirás una cotización automática por email.', 'orden' => 1],
            ['pregunta' => '¿Cuánto tiempo tarda la cotización?', 'respuesta' => 'La cotización estimada es automática. La cotización final puede ajustarse tras la revisión in situ por nuestro técnico.', 'orden' => 2],
            ['pregunta' => '¿Qué formas de pago aceptan?', 'respuesta' => 'Aceptamos efectivo, transferencia bancaria y tarjeta. El pago se coordina con el técnico o en oficina.', 'orden' => 3],
        ];

        foreach ($faqs as $faq) {
            Faq::create(array_merge($faq, ['activo' => true]));
        }

        $this->command->info('Se han creado ' . count($faqs) . ' FAQs iniciales.');
    }
}
