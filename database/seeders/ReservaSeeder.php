<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\ReservaGrupal;
use App\Models\User;

class ReservaSeeder extends Seeder{
    public function run()
    {
        // asociamos un usuario 
        $user = User::first() ?? User::factory()->create();

        $espacio = Espacio::first() ?? Espacio::factory()->create();

        // creamos una reserva simple
        $reserva = Reserva::create([
            'espacio_id' => $espacio->id,
            'user_id' => $user->id,
            'fecha_inicio' => now()->addDays(1),
            'fecha_fin' => now()->addDays(1)->addHours(2),
            'estado' => 'confirmada',
        ]);

        // creamos una reserva grupal asociada a la reserva
        ReservaGrupal::create([
            // vinculamos
            'reserva_id' => $reserva->id, 
            'aforo_max' => 15,
        ]);
    }
}