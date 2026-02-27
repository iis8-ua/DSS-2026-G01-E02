<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;

class HorarioSeeder extends Seeder
{
    public function run(): void
    {
        Horario::create([
            'inicio' => '2026-09-01 08:00:00',
            'fin'    => '2026-09-01 10:00:00',
        ]);

        Horario::create([
            'inicio' => '2026-09-01 10:00:00',
            'fin'    => '2026-09-01 12:00:00',
        ]);

        Horario::create([
            'inicio' => '2026-09-01 12:00:00',
            'fin'    => '2026-09-01 14:00:00',
        ]);

        Horario::create([
            'inicio' => '2026-09-01 15:00:00',
            'fin'    => '2026-09-01 17:00:00',
        ]);

        Horario::create([
            'inicio' => '2026-09-01 17:00:00',
            'fin'    => '2026-09-01 19:00:00',
        ]);


        Horario::create([
            'inicio' => '2026-09-02 08:30:00',
            'fin'    => '2026-09-02 11:30:00',
        ]);

        Horario::create([
            'inicio' => '2026-09-02 16:00:00',
            'fin'    => '2026-09-02 20:00:00',
        ]);
    }
}
