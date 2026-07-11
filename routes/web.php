<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\PrioridadController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\HistorialEstadoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\EvidenciaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\UserController;

Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::resource('incidencias', IncidenciaController::class);

    Route::patch(
        '/incidencias/{incidencia}/estado',
        [IncidenciaController::class, 'cambiarEstado']
    )->name('incidencias.cambiar-estado');

    Route::resource('roles', RolController::class);

    Route::resource('paises', PaisController::class);

    Route::resource('provincias', ProvinciaController::class);

    Route::resource('ciudades', CiudadController::class);

    Route::resource('estados', EstadoController::class);

    Route::resource('prioridades', PrioridadController::class);

    Route::resource('asignaciones', AsignacionController::class);

    Route::resource('historial-estados', HistorialEstadoController::class);

    Route::resource('comentarios', ComentarioController::class);

    Route::resource('evidencias', EvidenciaController::class);

    Route::resource('notificaciones', NotificacionController::class);

});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('users', UserController::class);

});
