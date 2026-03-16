<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller {
    public function index() {
        // obtenemos el alumno autenticado
        $alumno_id = Auth::id();

        // obtenemos las reservas del alumno junto con el espacio asociado
        $reservas = Reserva::with('espacio')
                           ->where('user_id', $alumno_id)
                           ->orderBy('fecha_inicio', 'desc')
                           ->get();

        // llamamos a la vista que tendrá el componente history
        return view('usuario', ['reservas' => $reservas]);
    }
}