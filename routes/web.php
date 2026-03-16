<?php

use App\Http\Controllers\EspacioController;
use Illuminate\Support\Facades\Route;
use App\Models\Espacio;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UsuarioController;
>>>>>>>>> Temporary merge branch 2

Route::get('/', function () {
    return view('main');
})->name('inicio');

Route::get('/catalogo', function () {
    $espacios = Espacio::all();
    return view('reservations', ['espacios' => $espacios]);
})->name('espacios.catalogo');

<<<<<<<<< Temporary merge branch 1
Route::get('/perfil', [UsuarioController::class, 'perfil'])
->middleware('auth')->name('usuario.perfil');
=========
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');

>>>>>>>>> Temporary merge branch 2

Route::view('/aviso-legal', 'aviso-legal')->name('legal.aviso');
Route::view('/privacidad', 'privacidad')->name('legal.privacidad');
Route::view('/accesibilidad', 'accesibilidad')->name('legal.accesibilidad');
Route::view('/cookies', 'cookies')->name('legal.cookies');


Route::resource('espacios', EspacioController::class);
Route::resource('reservas', ReservaController::class);
