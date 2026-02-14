<?php

use App\Http\Controllers\Api\ServicioController;
use App\Http\Controllers\Api\GaleriaController;
use App\Http\Controllers\Api\SolicitudController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\ContactoController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/servicios', [ServicioController::class, 'index']);
Route::get('/servicios/{slug}', [ServicioController::class, 'show']);
Route::get('/galeria', [GaleriaController::class, 'index']);
Route::get('/faq', [FaqController::class, 'index']);

// Ruta de contacto
Route::post('/contacto', [ContactoController::class, 'enviar']);

// Ruta para obtener información de contacto
Route::get('/contacto-info', function () {
    $info = \App\Models\ContactoInfo::getInfo();
    return response()->json([
        'success' => true,
        'data' => $info
    ]);
});

// Ruta para obtener configuración del hero
Route::get('/hero-settings', function () {
    $settings = \App\Models\HeroSetting::getSettings();
    return response()->json([
        'success' => true,
        'data' => $settings
    ]);
});

// Rutas de autenticación
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/solicitudes', [SolicitudController::class, 'userSolicitudes']);
    Route::post('/solicitudes', [SolicitudController::class, 'store']);
    Route::get('/solicitudes/{id}', [SolicitudController::class, 'show']);
});
