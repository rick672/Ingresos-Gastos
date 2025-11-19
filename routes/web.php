<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin'); // Redirige al panel de Filament
});

// Route::get('/', function () {
//     return view('welcome');
// });
