<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;

class BlogController extends Controller{
    public function index(){
        
        // obtenemos todas las incidencias
        // como necesitamos el usuario y la reserva, las obtenemos con with
        $incidencias = Incidencia::with(['user', 'reserva'])->latest()->get();

        // lo enviamos a la vista del blog de incidencias
        return view('blog', compact('incidencias'));
    }
}