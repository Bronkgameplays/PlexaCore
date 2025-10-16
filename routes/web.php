<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\CloudFleet_Conductores;
use App\Http\Controllers\HabitacionController;

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

Route::get('/login', function () {
    return view('login');
});

Route::get('/tablas', [ConductorController::class, 'index']);
Route::get('/tablas', [ConductorController::class, 'tablas'])->name('tablas');        // Leer Conductores
Route::get('/hotel', [HabitacionController::class, 'hotel']); //Leer Habitaciones
Route::put('/habitaciones/{numero}', [HabitacionController::class, 'update'])->name('habitaciones.update');
Route::get('/conductores/{id}', [ConductorController::class, 'show']);    // Leer uno
Route::post('/conductores', [ConductorController::class, 'store']);       // Crear
Route::put('/conductores/{id}', [ConductorController::class, 'update']);  // Actualizar
Route::delete('/conductores/{id}', [ConductorController::class, 'destroy']); // Borrar
Route::get('/conductores/buscar', [ConductorController::class, 'buscarDisponibles'])->name('conductores.buscar');
Route::post('/habitaciones/{id}/asignar', [HabitacionController::class, 'asignarConductor'])->name('habitaciones.asignar');
Route::post('/habitaciones/{id}/desasignar', [HabitacionController::class, 'desasignarConductor'])->name('habitaciones.desasignar');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');




Route::get('/cloud_conductor/', [CloudFleet_Conductores::class, 'obtenerTodos'])->name('actualizarconductores');

Route::get('/utilidades', function () {
    return view('buttons');
});
