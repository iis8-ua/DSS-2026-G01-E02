<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\ReservaGrupal;
use App\Models\User;

class ReservaSeeder extends Seeder
{
    public function run()
    {
        // asociamos un usuario 
        $user = User::first() ?? User::factory()->create();

        // creamos una reserva simple
        $reserva = Reserva::create([
            'fecha_hora' => fake()->dateTimeBetween('now', '+1 month'),
            'estado' => 'confirmada',
            'user_id' => $user->id,
        ]);

        // creamos una reserva grupal asociada a la reserva
        ReservaGrupal::create([
            // vinculamos
            'reserva_id' => $reserva->id, 
            'numero_personas' => 15,
            'nombre_grupo' => 'Grupo de Estudio DSS',
        ]);
    }
}