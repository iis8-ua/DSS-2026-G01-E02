<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notificacion;
use App\Models\Usuario;
use App\Models\Incidencia;

class NotificacionSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = Usuario::all();
        $incidencia = Incidencia::first();

        if ($usuarios->count() > 0) {
            foreach ($usuarios as $index => $user) {
                Notificacion::create([
                    'titulo' => "Bienvenido",
                    'texto' => "Hola {$user->name}, bienvenido al sistema.",
                    'vista' => true,
                    'imagen'  => 'bienvenida.jpg',
                    'user_id' => $user->id,
                ]);
                if ($index === 0 && $incidencia) {
                    Notificacion::create([
                        'titulo' => "Incidencia registrada",
                        'texto' => "Tu incidencia '{$incidencia->descripcion}' ha sido registrada.",
                        'vista' => false,
                        'user_id' => $user->id,
                        'incidencia_id' => $incidencia->id,
                    ]);
                }
            }
        }
    }
}
