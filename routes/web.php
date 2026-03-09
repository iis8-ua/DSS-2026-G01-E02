<?php

use Illuminate\Support\Facades\Route;
use App\Models\Espacio;

Route::get('/', function () {
    return view('main');
})->name('inicio');

Route::get('/catalogo', function () {
    $espacios = Espacio::all();
    return view('reservations', ['espacios' => $espacios]);
})->name('espacios.catalogo');

Route::get('/admin', function () {
    return view('admin', [
        'usuarios' => [],
        'espacios' => [],
        'reservas' => [],
    ]);
});

Route::get('/blog', function () {
    return view('blog', [
        'incidencias' => [],
    ]);
});

Route::view('/aviso-legal', 'aviso-legal')->name('legal.aviso');
Route::view('/privacidad', 'privacidad')->name('legal.privacidad');
Route::view('/accesibilidad', 'accesibilidad')->name('legal.accesibilidad');
Route::view('/cookies', 'cookies')->name('legal.cookies');


Route::resource('espacios', EspacioController::class);
Route::resource('reservas', ReservaController::class);