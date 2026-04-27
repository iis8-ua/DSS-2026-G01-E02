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
            'dni' => [
            'required',
            'string',
            'unique:usuarios,dni',
            'regex:/^[0-9]{8}[A-Za-z]$/',
            function ($attribute, $value, $fail) {
                $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
                $numero = (int) substr($value, 0, 8);
                $letra = strtoupper(substr($value, -1));
                
                // Si la letra calculada no coincide con la escrita, da error
                if ($letras[$numero % 23] !== $letra) {
                    $fail('La letra del DNI introducido no es correcta.');
                }
            },
            ],
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
        ], [
            // Mensajes de error
            'dni.regex' => 'El formato del DNI debe ser de 8 números seguidos de una letra.',
            'email.email' => 'El correo electrónico no es válido o el dominio no existe.',
            'email.unique' => 'Ya existe una cuenta registrada con este correo.',
            'dni.unique' => 'Este DNI ya está registrado con una cuenta.',
        ]
        );

        $usuario = new Usuario();
        $usuario->dni = $request->dni;
        $usuario->name = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        // $usuario->tipo_usuario = $request->tipo_usuario;
        $usuario->tipo_usuario = 'ALUMNO';
        $usuario->save();

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('inicio');
        }
        return back()->withErrors(['email' => 'Registro exitoso pero hubo un error al iniciar sesión.']);
    }
}
