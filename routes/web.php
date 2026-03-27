<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\LocalizacionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TipoEspacioController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HorarioController;
use App\Models\Espacio;


Route::get('/', [NotificationController::class, 'getNotificationsAsUser'])
    //->middleware('auth')
    ->name('inicio');

Route::post('/notificacion/{id}/view', [NotificationController::class, 'viewNotification'])
    ->name('notification.view');
Route::post('/notificacion/viewall', [NotificationController::class, 'viewAllNotificationsAsUser'])
    ->name('notification.viewall');

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


Route::view('/login', 'login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/reservas/nueva/{espacio}', function (Espacio $espacio) {
    return view('new_reservation', compact('espacio'));
})->name('reservas.nueva');

Route::view('/aviso-legal', 'aviso-legal')->name('legal.aviso');
Route::view('/privacidad', 'privacidad')->name('legal.privacidad');
Route::view('/accesibilidad', 'accesibilidad')->name('legal.accesibilidad');
Route::view('/cookies', 'cookies')->name('legal.cookies');

Route::patch('/reservas/{reserva}/aprobar', [ReservaController::class, 'aprobar'])->name('reservas.aprobar');
Route::patch('/reservas/{reserva}/rechazar', [ReservaController::class, 'rechazar'])->name('reservas.rechazar');

Route::resource('espacios', EspacioController::class);
Route::resource('tipos-espacio', TipoEspacioController::class);
Route::resource('localizaciones', LocalizacionController::class);
Route::resource('horarios', HorarioController::class);
Route::resource('incidencias', IncidenciaController::class);