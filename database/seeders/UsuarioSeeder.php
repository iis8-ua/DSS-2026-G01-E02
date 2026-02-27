<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'name'         => 'Juan',
            'apellidos'    => 'Pérez García',
            'email'        => 'juan.perez@email.com',
            'password'     => Hash::make('12345678'),
            'dni'          => '12345678A',
            'tipo_usuario' => 'ALUMNO',
        ]);

        Usuario::create([
            'name'         => 'María',
            'apellidos'    => 'López Gómez',
            'email'        => 'maria.lopez@email.com',
            'password'     => Hash::make('12345678'),
            'dni'          => '87654321B',
            'tipo_usuario' => 'ALUMNO',
        ]);

        Usuario::create([
            'name'         => 'Carlos',
            'apellidos'    => 'Ruiz Sánchez',
            'email'        => 'carlos.ruiz@email.com',
            'password'     => Hash::make('12345678'),
            'dni'          => '11223344C',
            'tipo_usuario' => 'ALUMNO',
        ]);


        Usuario::create([
            'name'         => 'Laura',
            'apellidos'    => 'Martínez Fernández',
            'email'        => 'laura.martinez@email.com',
            'password'     => Hash::make('12345678'),
            'dni'          => '55667788D',
            'tipo_usuario' => 'GESTOR_ESPACIOS',
        ]);

        Usuario::create([
            'name'         => 'Antonio',
            'apellidos'    => 'García Navarro',
            'email'        => 'antonio.garcia@email.com',
            'password'     => Hash::make('12345678'),
            'dni'          => '99887766E',
            'tipo_usuario' => 'GESTOR_ESPACIOS',
        ]);
    }
}
