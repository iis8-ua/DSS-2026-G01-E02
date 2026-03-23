<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\LocalizacionController;
use App\Http\Controllers\TipoEspacioController;
use App\Http\Controllers\UsuarioController;
use App\Models\Espacio;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('inicio');

Route::get('/catalogo', [EspacioController::class, 'catalogo'])->name('espacios.catalogo');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::get('/blog', function () {
    return view('blog', [
        'incidencias' => [],
    ]);
})->name('blog');

Route::get('/perfil', [UsuarioController::class, 'perfil'])
    ->middleware('auth')
    ->name('perfil');

Route::view('/login', 'login')->name('login');

Route::get('/reservas/nueva/{espacio}', function (Espacio $espacio) {
    return view('new_reservation', compact('espacio'));
})->name('reservas.nueva');

Route::view('/aviso-legal', 'aviso-legal')->name('legal.aviso');
Route::view('/privacidad', 'privacidad')->name('legal.privacidad');
Route::view('/accesibilidad', 'accesibilidad')->name('legal.accesibilidad');
Route::view('/cookies', 'cookies')->name('legal.cookies');

Route::resource('espacios', EspacioController::class);
Route::resource('tipos-espacio', TipoEspacioController::class);
Route::resource('localizaciones', LocalizacionController::class);