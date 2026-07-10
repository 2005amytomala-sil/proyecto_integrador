<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\CiudadController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/incidencias', [IncidenciaController::class, 'apiIndex']);

Route::get('/paises', [PaisController::class, 'index']);

Route::get('/provincias/{pais}', [ProvinciaController::class, 'porPais']);

Route::get('/ciudades/{provincia}', [CiudadController::class, 'porProvincia']);