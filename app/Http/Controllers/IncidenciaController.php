<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;

class IncidenciaController extends Controller{
    public function index(){

        // obtenemos todas las incidencias
        // como necesitamos el usuario, lo obtenemos con with
        $incidencias = Incidencia::with(['usuario'])->get();

        // lo enviamos a la vista del blog de incidencias
        return view('blog', compact('incidencias'));
    }
}
