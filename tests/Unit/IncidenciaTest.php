<?php

namespace Tests\Unit;

use App\Models\Incidencia;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncidenciaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test creación
     * @test
     */
    public function T01_create_should_persist_incidencia_and_generate_uuid()
    {
        //arrange
        $usuario = Usuario::create([
            'name'         => 'Test',
            'apellidos'    => 'User',
            'email'        => 'incidencia.test@example.com',
            'password'     => bcrypt('password'),
            'dni'          => '12345678I',
            'tipo_usuario' => 'ALUMNO'
        ]);

        //act
        $incidencia = Incidencia::create([
            'descripcion' => 'El proyector del Aula Magna no enciende.',
            'user_id'     => $usuario->id
        ]);

        //asert
        $this->assertNotNull($incidencia->id);
        $this->assertEquals('El proyector del Aula Magna no enciende.', $incidencia->descripcion);
        $this->assertEquals($usuario->id, $incidencia->user_id);
    }

    /**
     * Test relacion con usuario
     * @test
     */
    public function T02_usuario_relation_returns_the_associated_user()
    {
        //arrange
        $usuario = Usuario::create([
            'name'         => 'María',
            'apellidos'    => 'Gómez',
            'email'        => 'maria.gomez@example.com',
            'password'     => bcrypt('password'),
            'dni'          => '87654321M',
            'tipo_usuario' => 'PROFESOR'
        ]);

        $incidencia = Incidencia::create([
            'descripcion' => 'Silla rota en el laboratorio 3',
            'user_id'     => $usuario->id
        ]);

        //act
        $resultado = $incidencia->usuario;

        //assert
        $this->assertInstanceOf(Usuario::class, $resultado);
        $this->assertEquals($usuario->id, $resultado->id);
        $this->assertEquals('María', $resultado->name);
    }
}
