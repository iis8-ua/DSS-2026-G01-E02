<?php

use App\Http\Controllers\EspacioController;
use App\Http\Controllers\LocalizacionController;
use App\Http\Controllers\TipoEspacioController;
use Illuminate\Support\Facades\Route;
use App\Models\Espacio;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('main');
})->name('inicio');

Route::get('/catalogo', [EspacioController::class, 'catalogo'])->name('espacios.catalogo');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::get('/blog', function () {
    return view('blog', [
        'incidencias' => [],
    ]);
});

Route::get('/perfil', [UsuarioController::class, 'perfil'])
->middleware('auth')->name('usuario.perfil');

Route::view('/aviso-legal', 'aviso-legal')->name('legal.aviso');
Route::view('/privacidad', 'privacidad')->name('legal.privacidad');
Route::view('/accesibilidad', 'accesibilidad')->name('legal.accesibilidad');
Route::view('/cookies', 'cookies')->name('legal.cookies');


Route::resource('espacios', EspacioController::class);
Route::resource('reservas', ReservaController::class);
Route::resource('tipos-espacio', TipoEspacioController::class);
Route::resource('localizaciones', LocalizacionController::class);
