<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Notificacion;
use App\Models\ReservaGrupal;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Espacio;
use App\Models\Reserva;
use App\Models\Horario;
use App\Models\TipoEspacio;
use App\Models\Localizacion;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsuarios = Usuario::count();
        $totalEspacios = Espacio::count();
        $totalReservas = Reserva::count();
        $totalTipos = TipoEspacio::count();
        $totalLocalizaciones = Localizacion::count();
        $totalHorarios = Horario::count();
        $totalIncidencias=Incidencia::count();
        $totalNotificaciones = Notificacion::count();
        $totalReservasGrupales = ReservaGrupal::count();

        return view('admin', compact(
            'totalUsuarios',
            'totalEspacios',
            'totalReservas',
            'totalTipos',
            'totalLocalizaciones',
            'totalHorarios',
            'totalIncidencias',
            'totalNotificaciones',
            'totalReservasGrupales'
        ));
    }
}
