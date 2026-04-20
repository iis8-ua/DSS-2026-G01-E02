<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->tipo_usuario === 'ADMIN') {
                return redirect()->route('admin.index');
            }
            else if (Auth::user()->tipo_usuario === 'GESTOR_ESPACIOS') {
                return redirect()->route('gestor.reservas.pendientes');
            }

            return redirect()->route('inicio');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

    public function register(Request $request){
        $request->validate([
            'dni' => 'required|string|max:15|unique:usuarios,dni',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'tipo_usuario' => 'required|string',
        ]);

        $usuario = new Usuario();
        $usuario->dni = $request->dni;
        $usuario->name = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->tipo_usuario = $request->tipo_usuario;
        $usuario->save();

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('inicio');
        }
        return back()->withErrors(['email' => 'Registro exitoso pero hubo un error al iniciar sesión.']);
    }
}
