<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Localizacion;

class LocalizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Localizacion::create(['latitud' => 38.384, 'longitud' => -0.512, 'piso' => -1]);
        Localizacion::create(['latitud' => 38.384, 'longitud' => -0.512, 'piso' => 0]);
        Localizacion::create(['latitud' => 38.384, 'longitud' => -0.512, 'piso' => 1]);
        Localizacion::create(['latitud' => 38.384, 'longitud' => -0.512, 'piso' => 2]);
        Localizacion::create(['latitud' => 38.384, 'longitud' => -0.512, 'piso' => 3]);
        Localizacion::create(['latitud' => 38.384, 'longitud' => -0.512, 'piso' => 4]);

        Localizacion::create(['latitud' => 38.3845, 'longitud' => -0.5125, 'piso' => 0]);
        Localizacion::create(['latitud' => 38.3845, 'longitud' => -0.5125, 'piso' => 1]);
        Localizacion::create(['latitud' => 38.3845, 'longitud' => -0.5125, 'piso' => 2]);
        Localizacion::create(['latitud' => 38.3845, 'longitud' => -0.5125, 'piso' => 3]);

        Localizacion::create(['latitud' => 38.3835, 'longitud' => -0.5115, 'piso' => -1]);
        Localizacion::create(['latitud' => 38.3835, 'longitud' => -0.5115, 'piso' => 0]);
        Localizacion::create(['latitud' => 38.3835, 'longitud' => -0.5115, 'piso' => 1]);
        Localizacion::create(['latitud' => 38.3835, 'longitud' => -0.5115, 'piso' => 2]);

        Localizacion::create(['latitud' => 38.3830, 'longitud' => -0.5130, 'piso' => 0]);
        Localizacion::create(['latitud' => 38.3830, 'longitud' => -0.5130, 'piso' => 1]);
        Localizacion::create(['latitud' => 38.3830, 'longitud' => -0.5130, 'piso' => 2]);

        Localizacion::create(['latitud' => 38.3850, 'longitud' => -0.5140, 'piso' => 0]);
        Localizacion::create(['latitud' => 38.3850, 'longitud' => -0.5140, 'piso' => 1]);
    }
}