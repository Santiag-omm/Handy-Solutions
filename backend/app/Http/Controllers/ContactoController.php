<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoMail;
use App\Models\Contacto;

class ContactoController extends Controller
{
    /**
     * Procesar el formulario de contacto
     */
    public function enviar(Request $request)
    {
        try {
            // Validar los datos
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telefono' => 'nullable|string|max:20',
                'asunto' => 'required|string|in:consulta,servicio,cotizacion,reclamo,otro',
                'mensaje' => 'required|string|max:2000',
            ], [
                'nombre.required' => 'El nombre es obligatorio',
                'email.required' => 'El correo electrónico es obligatorio',
                'email.email' => 'El correo electrónico no es válido',
                'asunto.required' => 'El asunto es obligatorio',
                'mensaje.required' => 'El mensaje es obligatorio',
                'mensaje.max' => 'El mensaje no puede exceder los 2000 caracteres',
            ]);

            // Guardar en base de datos
            $contacto = Contacto::create([
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'telefono' => $validated['telefono'],
                'asunto' => $validated['asunto'],
                'mensaje' => $validated['mensaje'],
                'estado' => 'pendiente',
                'fecha_envio' => now(),
            ]);

            // Enviar correo (simulado por ahora)
            // Mail::to('info@handysolutions.com')->send(new ContactoMail($validated));

            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado con éxito. Nos pondremos en contacto contigo pronto.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Error en contacto: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje. Por favor, intenta nuevamente.'
            ], 500);
        }
    }
}
