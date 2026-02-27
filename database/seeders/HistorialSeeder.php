<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Historial;
use App\Models\Usuario;
use App\Models\Reserva;

class HistorialSeeder extends Seeder
{
    public function run(): void
    {
        $alumnos = Usuario::where('tipo_usuario', 'ALUMNO')->get();

        foreach ($alumnos as $alumno) {
            $historial = Historial::create([
                'user_id' => $alumno->id,
            ]);
        }
    }
}
