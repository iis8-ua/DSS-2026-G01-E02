<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //
    public function perfil(){
        //$usuario = Auth::user();
        $usuario = new Usuario();
        $usuario->name = "Usuario";
        $usuario->apellidos = "Apellido1 Apellido2";
        $usuario->email = "usuario@ejemplo.com";
        $usuario->password = "123456";
        $usuario->dni = "00000000T";
        $usuario->tipo_usuario = "gestor";
        return view('usuario', ['usuario' => $usuario]);
    }
}
