<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class ImageValidationController extends Controller
{
    /**
     * Validar URL de imagen en tiempo real
     */
    public function validateImageUrl(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'URL inválida'
            ], 400);
        }

        $url = $request->url;
        
        try {
            // Usar Guzzle para hacer petición HEAD
            $client = new Client(['timeout' => 10]);
            $response = $client->head($url);
            $statusCode = $response->getStatusCode();
            
            if ($statusCode !== 200) {
                return response()->json([
                    'success' => false,
                    'error' => 'La URL no responde (Error ' . $statusCode . ')'
                ], 400);
            }

            // Verificar que sea una imagen
            $contentType = strtolower($response->getHeaderLine('Content-Type'));
            if (!str_contains($contentType, 'image/')) {
                return response()->json([
                    'success' => false,
                    'error' => 'La URL no apunta a una imagen (Content-Type: ' . $contentType . ')'
                ], 400);
            }

            // Obtener información adicional de la imagen
            $contentLength = $response->getHeaderLine('Content-Length');
            $sizeText = $contentLength ? $this->formatBytes($contentLength) : 'Desconocido';

            return response()->json([
                'success' => true,
                'message' => 'URL válida y accesible',
                'details' => [
                    'content_type' => $contentType,
                    'size' => $sizeText,
                    'status' => $statusCode
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al verificar la URL: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Formatear bytes a texto legible
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
