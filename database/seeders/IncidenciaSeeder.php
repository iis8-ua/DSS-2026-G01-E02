<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incidencia;
use App\Models\Usuario;

class IncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();

        if ($usuarios->count() == 0) {
            $this->command->warn('No hay usuarios en la base de datos para asignar las incidencias.');
            return;
        }

        $incidenciasParaCrear = [
            [
                'descripcion' => 'La silla de la fila 3 está totalmente rota y es peligrosa.',
                'foto'        => 'silla_rota.jpg',
            ],
            [
                'descripcion' => 'El proyector parpadea y se apaga solo a los 10 minutos de uso.',
                'foto'        => 'proyector_fallo.png',
            ],
            [
                'descripcion' => 'Hay una gotera importante en el techo que moja las mesas.',
                'foto'        => 'gotera_techo.jpg',
            ],
        ];

        foreach ($incidenciasParaCrear as $index => $data) {
            $usuarioAsignado = $usuarios[$index % $usuarios->count()];

            Incidencia::create([
                'descripcion' => $data['descripcion'],
                'foto'        => $data['foto'],
                'user_id'  => $usuarioAsignado->id,
            ]);
        }
    }
}
