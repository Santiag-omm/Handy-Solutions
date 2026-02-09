<?php

use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrdenTrabajoController;
use App\Http\Controllers\Admin\PagoController;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\SolicitudAdminController;
use App\Http\Controllers\Admin\TecnicoController;
use App\Http\Controllers\Admin\ZonaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

// Público
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/servicios', [HomeController::class, 'servicios'])->name('servicios.index');
Route::get('/servicios/{slug}', [HomeController::class, 'servicio'])->name('servicios.show');
Route::get('/galeria', [HomeController::class, 'galeria'])->name('galeria');
Route::get('/contacto', [HomeController::class, 'contacto'])->name('contacto');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Password reset
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class])->name('password.email');
});
Route::get('/reset-password/{token}', fn (string $token) => view('auth.reset-password', ['token' => $token]))->name('password.reset');
Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class])->name('password.update');

// Solicitudes (requieren auth para crear/ver)
Route::middleware('auth')->group(function () {
    Route::get('/solicitar-servicio', [SolicitudController::class, 'create'])->name('solicitudes.create');
    Route::post('/solicitudes', [SolicitudController::class, 'store'])->name('solicitudes.store');
    Route::get('/solicitudes/{id}', [SolicitudController::class, 'show'])->name('solicitudes.show');
});

// Panel admin (solo administrador con CRUD completo)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('servicios', ServicioController::class)->except(['show']);
    Route::resource('tecnicos', TecnicoController::class)->except(['show']);
    Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::resource('zonas', ZonaController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('solicitudes', [SolicitudAdminController::class, 'index'])->name('solicitudes.index');
    Route::get('solicitudes/{solicitud}', [SolicitudAdminController::class, 'show'])->name('solicitudes.show');
    Route::post('solicitudes/{solicitud}/validar', [SolicitudAdminController::class, 'validar'])->name('solicitudes.validar');
    Route::post('solicitudes/{solicitud}/rechazar', [SolicitudAdminController::class, 'rechazar'])->name('solicitudes.rechazar');
    Route::post('solicitudes/{solicitud}/cotizar', [SolicitudAdminController::class, 'cotizar'])->name('solicitudes.cotizar');

    Route::get('ordenes', [OrdenTrabajoController::class, 'index'])->name('ordenes.index');
    Route::get('ordenes/crear/{solicitud}', [OrdenTrabajoController::class, 'create'])->name('ordenes.create');
    Route::post('ordenes', [OrdenTrabajoController::class, 'store'])->name('ordenes.store');
    Route::get('ordenes/{orden}', [OrdenTrabajoController::class, 'show'])->name('ordenes.show');
    Route::patch('ordenes/{orden}/estado', [OrdenTrabajoController::class, 'updateEstado'])->name('ordenes.estado');

    Route::post('pagos', [PagoController::class, 'store'])->name('pagos.store');
});
