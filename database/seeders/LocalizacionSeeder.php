<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Localizacion;

class LocalizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Localizacion::create(['latitud' => 40.5, 'longitud' => -3.5, 'piso' => 1]);
        Localizacion::create(['latitud' => 40.5, 'longitud' => -3.5, 'piso' => 2]);
        Localizacion::create(['latitud' => 41.0, 'longitud' => -2.0, 'piso' => 0]);
    }
}
