<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Espacio;
use App\Models\Reserva;

class AdminController extends Controller{
    public function index(){
        // obtenemos todos los usuarios
        $usuarios = Usuario::all();

        // Obtenemos todos los espacios
        // with para obtener el tipo de espacio asociado
        $espacios = Espacio::with('tipo')->get();

        // Obtenemos todas las reservas
        // obtenemos también su alumno y espacio asociados
        $reservas = Reserva::with(['alumno', 'espacio'])->get();

        // los enviamos todos a la vista del admin
        return view('admin', compact('usuarios', 'espacios', 'reservas'));
    }
}
