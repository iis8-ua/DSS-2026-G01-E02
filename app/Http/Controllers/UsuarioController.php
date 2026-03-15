<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //
    public function perfil(){
        $usuario = Auth::user();
        return view('usuario', ['usuario' => $usuario]);
    }
}
