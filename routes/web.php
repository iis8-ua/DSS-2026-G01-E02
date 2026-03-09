<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspacioController;

Route::get('/', function () {
    return view('main');
})->name('inicio');

Route::get('/catalogo', [EspacioController::class, 'index'])->name('espacios.catalogo');

Route::view('/aviso-legal', 'aviso-legal')->name('legal.aviso');
Route::view('/privacidad', 'privacidad')->name('legal.privacidad');
Route::view('/accesibilidad', 'accesibilidad')->name('legal.accesibilidad');
Route::view('/cookies', 'cookies')->name('legal.cookies');
