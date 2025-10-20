<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\CloudFleet_Conductores;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\LoginController;

// ----------------------
// RUTAS PÚBLICAS (sin login)
// ----------------------
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// ----------------------
// RUTAS PROTEGIDAS (requieren sesión)
// ----------------------
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::get('/index', function () {
        return view('index');
    });

    Route::get('/tablas', [ConductorController::class, 'tablas'])->name('tablas');
    Route::get('/hotel', [HabitacionController::class, 'hotel'])->name('hotel');
    Route::get('/gestiondehotel', function () {
        return view('gestiondehotel');
    });
    Route::get('/utilidades', function () {
        return view('buttons');
    });

    // Conductores CRUD
    Route::get('/conductores/{id}', [ConductorController::class, 'show']);
    Route::post('/conductores', [ConductorController::class, 'store']);
    Route::put('/conductores/{id}', [ConductorController::class, 'update']);
    Route::delete('/conductores/{id}', [ConductorController::class, 'destroy']);
    Route::get('/conductores/buscar', [ConductorController::class, 'buscarDisponibles'])->name('conductores.buscar');

    // Habitaciones
    Route::put('/habitaciones/{numero}', [HabitacionController::class, 'update'])->name('habitaciones.update');
    Route::post('/habitaciones/{id}/asignar', [HabitacionController::class, 'asignarConductor'])->name('habitaciones.asignar');
    Route::post('/habitaciones/{id}/desasignar', [HabitacionController::class, 'desasignarConductor'])->name('habitaciones.desasignar');

    // CloudFleet
    Route::get('/cloud_conductor/', [CloudFleet_Conductores::class, 'obtenerTodos'])->name('actualizarconductores');

    // Logout (también requiere sesión)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
