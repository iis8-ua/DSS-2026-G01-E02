<?php

namespace App\Http\Controllers;
use App\Models\Espacio;
use App\Models\Notificacion;
use App\Models\Localizacion;
use Illuminate\Support\Facades\Auth;


class MapController extends Controller
{
    public function map(){
        $espacios = Espacio::with('localizacion')->get();
        $markers = $espacios->map(function($espacio) {
            $loc = $espacio->localizacion;
            return [
                'nombre' => $espacio->nombre,
                'latitud' => $loc->latitud,
                'longitud' => $loc->longitud,
                'piso' => $loc->piso ?? 0
            ];
        })->values()->toArray();

        $notifications = Notificacion::where('user_id', Auth::user()->id)->where('vista', false)->get();

        return view('main', [
            'notifications' => $notifications,
            'markers' => $markers
        ]);
    }
}
