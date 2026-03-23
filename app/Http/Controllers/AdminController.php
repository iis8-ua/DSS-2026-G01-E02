<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Espacio;
use App\Models\Reserva;
use App\Models\TipoEspacio;
use App\Models\Localizacion;

class AdminController extends Controller
{
    public function index()
    {
        // Obtenemos solo los totales para el Dashboard
        $totalUsuarios = Usuario::count();
        $totalEspacios = Espacio::count();
        $totalReservas = Reserva::count();
        $totalTipos = TipoEspacio::count();
        $totalLocalizaciones = Localizacion::count();

        //se sacan las reservas pendientes de aprobar ya que el admin tmbn puede hacer eso
        $ultimasReservas = Reserva::with(['alumno', 'espacio'])
            ->where('estado', 'PENDIENTE')
            ->latest()
            ->get();

        return view('admin', compact(
            'totalUsuarios',
            'totalEspacios',
            'totalReservas',
            'totalTipos',
            'totalLocalizaciones',
            'ultimasReservas'
        ));
    }
}