<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\GeocodificacionController;
use App\Http\Controllers\Api\OrganicoApiController;
use App\Http\Controllers\Api\MaquinariaApiController;
use App\Http\Controllers\Api\GanadoApiController;
use App\Http\Controllers\Api\AuthApiController;

use App\Models\Categoria;
use App\Models\TipoCultivo;
use App\Models\UnidadOrganico;
use App\Models\TipoMaquinaria;
use App\Models\MarcaMaquinaria;
use App\Models\EstadoMaquinaria;

// Geocodificación (para app móvil)
Route::get('/geocodificacion', [GeocodificacionController::class, 'reverse']);

// ========== ORGÁNICOS ==========
Route::get('/organicos', [OrganicoApiController::class, 'index']);
Route::get('/organicos/{id}', [OrganicoApiController::class, 'show']);
Route::post('/organicos', [OrganicoApiController::class, 'store']);
Route::put('/organicos/{id}', [OrganicoApiController::class, 'update']);
Route::delete('/organicos/{id}', [OrganicoApiController::class, 'destroy']);

// Catálogos orgánicos
Route::get('/categorias', function () {
    return response()->json([
        'status' => 'ok',
        'data'   => Categoria::orderBy('nombre')->get(),
    ]);
});

Route::get('/tipo-cultivos', function () {
    return response()->json([
        'status' => 'ok',
        'data'   => TipoCultivo::orderBy('nombre')->get(),
    ]);
});

Route::get('/unidades-organicos', function () {
    return response()->json([
        'status' => 'ok',
        'data'   => UnidadOrganico::orderBy('nombre')->get(),
    ]);
});

// ========== MAQUINARIAS ==========
Route::get('/maquinarias', [MaquinariaApiController::class, 'index']);
Route::get('/maquinarias/{id}', [MaquinariaApiController::class, 'show']);
Route::post('/maquinarias', [MaquinariaApiController::class, 'store']);
Route::put('/maquinarias/{id}', [MaquinariaApiController::class, 'update']);
Route::delete('/maquinarias/{id}', [MaquinariaApiController::class, 'destroy']);

// Catálogos maquinaria
Route::get('/tipos-maquinaria', function () {
    return response()->json([
        'status' => 'ok',
        'data'   => TipoMaquinaria::orderBy('nombre')->get(),
    ]);
});

Route::get('/marcas-maquinaria', function () {
    return response()->json([
        'status' => 'ok',
        'data'   => MarcaMaquinaria::orderBy('nombre')->get(),
    ]);
});

Route::get('/estados-maquinaria', function () {
    return response()->json([
        'status' => 'ok',
        'data'   => EstadoMaquinaria::orderBy('nombre')->get(),
    ]);
});

// ========== GANADOS ==========
Route::get('/ganados', [GanadoApiController::class, 'index']);
Route::get('/ganados/{id}', [GanadoApiController::class, 'show']);
Route::post('/ganados', [GanadoApiController::class, 'store']);
Route::put('/ganados/{id}', [GanadoApiController::class, 'update']);
Route::delete('/ganados/{id}', [GanadoApiController::class, 'destroy']);

// ========== AUTH ==========
Route::post('/login', [AuthApiController::class, 'login']);
