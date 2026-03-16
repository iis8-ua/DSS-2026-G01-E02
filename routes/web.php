<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspacioController;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('main');
})->name('inicio');

Route::get('/catalogo', [EspacioController::class, 'index'])->name('espacios.catalogo');

Route::view('/aviso-legal', 'aviso-legal')->name('legal.aviso');
Route::view('/privacidad', 'privacidad')->name('legal.privacidad');
Route::view('/accesibilidad', 'accesibilidad')->name('legal.accesibilidad');
Route::view('/cookies', 'cookies')->name('legal.cookies');
Route::get('/perfil', [UsuarioController::class, 'perfil'])
->middleware('auth')->name('usuario.perfil');
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

Route::resource('espacios', EspacioController::class);
Route::resource('reservas', ReservaController::class);