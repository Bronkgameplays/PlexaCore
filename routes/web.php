<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index'); // busca resources/views/index.blade.php
});

Route::get('/index', function () {
    return view('index'); // busca resources/views/index.blade.php
});

Route::get('/tablas', function () {
    return view('tablas'); // busca resources/views/tables.blade.php
});

Route::get('/hotel', function () {
    return view('hotel'); // busca resources/views/tables.blade.php
});