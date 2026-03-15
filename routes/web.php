<?php

use Illuminate\Support\Facades\Route;
use App\Models\Espacio;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('main');
})->name('inicio');

Route::get('/catalogo', function () {
    $espacios = Espacio::all();
    return view('reservations', ['espacios' => $espacios]);
})->name('espacios.catalogo');

Route::get('/perfil', [UsuarioController::class, 'perfil'])
->middleware('auth')->name('usuario.perfil');

Route::view('/aviso-legal', 'aviso-legal')->name('legal.aviso');
Route::view('/privacidad', 'privacidad')->name('legal.privacidad');
Route::view('/accesibilidad', 'accesibilidad')->name('legal.accesibilidad');
Route::view('/cookies', 'cookies')->name('legal.cookies');
