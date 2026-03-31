<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;

Route::get('/', function () {
    return view('agenda');
});

// rutas
Route::get('/api/contactos', [ContactoController::class, 'index']);
Route::post('/api/contactos', [ContactoController::class, 'store']);
Route::delete('/api/contactos/{id}', [ContactoController::class, 'destroy']);
Route::get('/api/contactos/{id}', [ContactoController::class, 'show']);
Route::put('/api/contactos/{id}', [ContactoController::class, 'update']);