<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\GestorEspaciosController;
use App\Http\Controllers\LocalizacionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReservaGrupalController;
use App\Http\Controllers\TipoEspacioController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HorarioController;

Route::get('/', [MapController::class, 'map'])
    ->middleware('auth')
    ->name('inicio');

Route::post('/notificacion/{id}/view', [NotificationController::class, 'viewNotification'])
    ->name('notification.view');
Route::post('/notificacion/viewall', [NotificationController::class, 'viewAllNotificationsAsUser'])
    ->name('notification.viewall');

Route::get('/catalogo', [EspacioController::class, 'catalogo'])->name('espacios.catalogo');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::get('/perfil', [UsuarioController::class, 'perfil'])
    ->middleware('auth')
    ->name('perfil');

Route::get('/mis-reservas', [ReservaController::class, 'misReservas'])
    ->middleware('auth')
    ->name('reservas.mias');

Route::view('/login', 'login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::view('/register', 'register')
    ->middleware('guest')
    ->name('register');

Route::post('/register', [LoginController::class, 'register'])
    ->middleware('guest');

Route::get('/reservas/nueva/{espacio}', [ReservaController::class, 'nueva'])
    ->middleware('auth')
    ->name('reservas.nueva');

Route::post('/reservas/nueva/{espacio}', [ReservaController::class, 'guardarNueva'])
    ->middleware('auth')
    ->name('reservas.guardarNueva');

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

Route::resource('notificaciones', NotificationController::class)->parameters([
    'notificaciones' => 'notificacion'
]);

Route::resource('reservas-grupales', ReservaGrupalController::class)->parameters([
    'reservas-grupales' => 'reservasGrupal'
]);

Route::resource('reservas', ReservaController::class);
Route::resource('usuarios', UsuarioController::class);
Route::get('/perfil/{usuario}/editar', [UsuarioController::class, 'editPerfil'])->name('usuario.edit-perfil');
Route::put('/perfil/{usuario}/actualizar', [UsuarioController::class, 'updatePerfil'])->name('usuario.update-perfil');

Route::get('/gestor/reservas/pendientes', [GestorEspaciosController::class, 'pendientes'])->name('gestor.reservas.pendientes');
Route::patch('/gestor/reservas/{reserva}/aceptar', [GestorEspaciosController::class, 'aceptar'])->name('gestor.reservas.aceptar');
Route::patch('/gestor/reservas/{reserva}/rechazar', [GestorEspaciosController::class, 'rechazar'])->name('gestor.reservas.rechazar');
