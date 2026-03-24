<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;

class HorarioSeeder extends Seeder
{
    public function run(): void
    {
        $horarios = [
            ['inicio' => '07:00', 'fin' => '08:00'],
            ['inicio' => '07:00', 'fin' => '09:00'],
            ['inicio' => '08:00', 'fin' => '09:00'],
            ['inicio' => '08:00', 'fin' => '10:00'],
            ['inicio' => '08:00', 'fin' => '12:00'],
            ['inicio' => '08:30', 'fin' => '10:30'],
            ['inicio' => '09:00', 'fin' => '10:00'],
            ['inicio' => '09:00', 'fin' => '11:00'],
            ['inicio' => '09:00', 'fin' => '13:00'],
            ['inicio' => '09:30', 'fin' => '11:30'],
            ['inicio' => '10:00', 'fin' => '11:00'],
            ['inicio' => '10:00', 'fin' => '12:00'],
            ['inicio' => '10:00', 'fin' => '14:00'],
            ['inicio' => '11:00', 'fin' => '12:00'],
            ['inicio' => '11:00', 'fin' => '13:00'],
            ['inicio' => '11:30', 'fin' => '13:30'],
            ['inicio' => '12:00', 'fin' => '13:00'],
            ['inicio' => '12:00', 'fin' => '14:00'],
            ['inicio' => '13:00', 'fin' => '14:00'],
            ['inicio' => '13:00', 'fin' => '15:00'],
            ['inicio' => '13:30', 'fin' => '15:30'],
            ['inicio' => '14:00', 'fin' => '15:00'],
            ['inicio' => '14:00', 'fin' => '16:00'],
            ['inicio' => '15:00', 'fin' => '16:00'],
            ['inicio' => '15:00', 'fin' => '17:00'],
            ['inicio' => '15:00', 'fin' => '19:00'],
            ['inicio' => '15:30', 'fin' => '17:30'],
            ['inicio' => '16:00', 'fin' => '17:00'],
            ['inicio' => '16:00', 'fin' => '18:00'],
            ['inicio' => '16:00', 'fin' => '20:00'],
            ['inicio' => '16:30', 'fin' => '18:30'],
            ['inicio' => '17:00', 'fin' => '18:00'],
            ['inicio' => '17:00', 'fin' => '19:00'],
            ['inicio' => '17:00', 'fin' => '21:00'],
            ['inicio' => '17:30', 'fin' => '19:30'],
            ['inicio' => '18:00', 'fin' => '19:00'],
            ['inicio' => '18:00', 'fin' => '20:00'],
            ['inicio' => '18:30', 'fin' => '20:30'],
            ['inicio' => '19:00', 'fin' => '20:00'],
            ['inicio' => '19:00', 'fin' => '21:00'],
            ['inicio' => '20:00', 'fin' => '21:00'],
            ['inicio' => '20:00', 'fin' => '22:00'],
            ['inicio' => '20:30', 'fin' => '22:30'],
            ['inicio' => '21:00', 'fin' => '22:00'],
            ['inicio' => '21:00', 'fin' => '23:00'],
            ['inicio' => '22:00', 'fin' => '23:00'],
            ['inicio' => '22:00', 'fin' => '23:59'],
        ];

        foreach ($horarios as $horario) {
            Horario::create($horario);
        }
    }
}
