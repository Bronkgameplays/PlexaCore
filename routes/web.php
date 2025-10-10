<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConductorController;

// Página principal
Route::get('/', function () {
    return view('index');
});

// Rutas adicionales
Route::get('/index', function () {
    return view('index');
});

Route::get('/tablas', function () {
    return view('tablas');
});

Route::get('/hotel', function () {
    return view('hotel');
});

Route::get('/gestiondehotel', function () {
    return view('gestiondehotel');
});

Route::get('/tablas', [ConductorController::class, 'index']);
Route::get('/conductores', [ConductorController::class, 'index']);        // Leer todos
Route::get('/conductores/{id}', [ConductorController::class, 'show']);    // Leer uno
Route::post('/conductores', [ConductorController::class, 'store']);       // Crear
Route::put('/conductores/{id}', [ConductorController::class, 'update']);  // Actualizar
Route::delete('/conductores/{id}', [ConductorController::class, 'destroy']); // Borrar
