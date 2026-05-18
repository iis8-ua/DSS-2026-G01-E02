<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\GestorEspacios;
use App\Enums\EstadoReserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GestorEspaciosController extends Controller
{
    public function pendientes()
    {
        $reservas = Reserva::with(['espacio', 'alumno'])
            ->where('estado', EstadoReserva::PENDIENTE)
            ->orderBy('hora_inicio', 'asc')
            ->paginate(10);

        return view('reservas-pendientes', compact('reservas'));
    }

    public function aceptar(Reserva $reserva)
    {
        if (Auth::user()->tipo_usuario == 'ALUMNO') {
            abort(403);
        }

        $gestor = GestorEspacios::withoutGlobalScopes()->find(auth()->id());
        $gestor->aceptarReserva($reserva);

        return back()->with('success', 'Reserva aceptada correctamente.');
    }

    public function rechazar(Reserva $reserva)
    {
        if (Auth::user()->tipo_usuario == 'ALUMNO') {
            abort(403);
        }

        $gestor = GestorEspacios::withoutGlobalScopes()->find(auth()->id());
        $gestor->rechazarReserva($reserva);

        return back()->with('success', 'Reserva rechazada correctamente.');
    }
}
