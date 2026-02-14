<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ContactoController;
use App\Http\Controllers\Admin\ContactoInfoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroSettingController;
use App\Http\Controllers\Admin\OrdenTrabajoController;
use App\Http\Controllers\Admin\PagoController;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\SolicitudAdminController;
use App\Http\Controllers\Admin\TecnicoController;
use App\Http\Controllers\Admin\ZonaController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Este backend expone únicamente:
| - Login web para administradores.
| - Panel de administración (rutas /admin) protegido por auth + role:admin.
|
*/

// Login de administrador
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Rutas protegidas (solo administrador)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
        Route::put('/account', [AccountController::class, 'update'])->name('account.update');

        Route::resource('servicios', ServicioController::class)->except(['show']);
        Route::resource('tecnicos', TecnicoController::class)->except(['show']);
        Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');
        Route::resource('zonas', ZonaController::class)->only(['index', 'store', 'update', 'destroy']);
        
        Route::get('contactos', [ContactoController::class, 'index'])->name('contactos.index');
        Route::get('contactos/{contacto}', [ContactoController::class, 'show'])->name('contactos.show');
        Route::put('contactos/{contacto}/estado', [ContactoController::class, 'updateEstado'])->name('contactos.updateEstado');
        Route::delete('contactos/{contacto}', [ContactoController::class, 'destroy'])->name('contactos.destroy');
        Route::post('contactos/marcar-leidos', [ContactoController::class, 'marcarLeidos'])->name('contactos.marcarLeidos');
        Route::post('contactos/eliminar-multiples', [ContactoController::class, 'eliminarMultiples'])->name('contactos.eliminarMultiples');
        
        Route::get('contacto-info', [ContactoInfoController::class, 'edit'])->name('contacto_info.edit');
        Route::put('contacto-info', [ContactoInfoController::class, 'update'])->name('contacto_info.update');
        
        Route::get('hero-settings', [HeroSettingController::class, 'edit'])->name('hero_settings.edit');
        Route::put('hero-settings', [HeroSettingController::class, 'update'])->name('hero_settings.update');

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
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
