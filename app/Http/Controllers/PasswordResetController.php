<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;

class PasswordResetController extends Controller
{
    // Muestra el formulario para introducir el email
    public function showLinkRequestForm()
    {
        return view('contraseña-olvidada');
    }

    // Envía el enlace para restablecer la contraseña por email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:usuarios,email']);

        // Generamos el token y lo mandamos usando el facade de Password
        $status = Password::broker('usuarios')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => 'Te hemos enviado el enlace para restablecer la contraseña.'])
                    : back()->withErrors(['email' => 'No se pudo enviar el enlace.']);
    }

    // Muestra el formulario para escribir la nueva contraseña
    public function showResetForm(Request $request, $token = null)
    {
        return view('recuperar-contraseña')->with(['token' => $token, 'email' => $request->email]);
    }

    // Procesa el cambio de contraseña
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::broker('usuarios')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', '¡Tu contraseña ha sido restablecida!')
                    : back()->withErrors(['email' => 'El token es inválido o ha expirado.']);
    }
}