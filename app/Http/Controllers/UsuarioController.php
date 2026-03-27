<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    //
    public function perfil(){
        $usuario = Auth::user();
        return view('usuario', ['usuario' => $usuario]);
    }

    public function create(){
        return view('create-usuarios');
    }

    // método para guardar el usuario en la base de datos
    public function store(Request $request)
    {
        // validamos que los datos que llegan del formulario son correctos
        $request->validate([
            'dni' => 'required|string|max:15|unique:usuarios,dni',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'tipo_usuario' => 'required|string',
        ]);

        // creamos el usuario y asignamos los valores
        $usuario = new Usuario();
        $usuario->dni = $request->dni;
        
        $usuario->name = $request->nombre; 
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;

        // encriptamos la contraseña antes de guardarla
        $usuario->password = Hash::make($request->password); 
        $usuario->tipo_usuario = $request->tipo_usuario;
        
        // Guardamos en la base de datos
        $usuario->save();

        // redirigimos a la vista del admin con un mensaje
        return redirect()->route('admin')->with('success', 'Usuario añadido correctamente.');
    }
}
