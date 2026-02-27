<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            TipoEspacioSeeder::class,
            LocalizacionSeeder::class,
            HorarioSeeder::class,
            EspacioSeeder::class,
            ReservaSeeder::class,
            HistorialSeeder::class,
            IncidenciaSeeder::class,
            NotificacionSeeder::class,
        ]);
    }
}
