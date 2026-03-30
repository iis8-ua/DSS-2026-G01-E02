<?php

namespace Tests\Unit;

use App\Models\Incidencia;
use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioTest extends TestCase
{

use RefreshDatabase;

    /**
     * Test de creacion
     * @test
     */
    public function T01_create_should_persist_usuario_and_generate_uuid()
    {
        //Arrange y act
        $usuario = Usuario::create([
            'name' => 'Juan',
            'apellidos' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'password' => bcrypt('password'),
            'dni' => '12345678A',
            'tipo_usuario' => 'usuario'
        ]);

        //assert
        $this->assertNotNull($usuario->id);
        $this->assertEquals('Juan', $usuario->name);
        $this->assertEquals('juan.perez@example.com', $usuario->email);
    }

    /**
     * Test del getfullname
     * @test
     */
    public function T02_getFullName_should_return_concatenated_name_and_apellidos(){
        //Arrange
        $usuario = new Usuario([
            'name' => 'Pepe',
            'apellidos' => 'Viyuela'
        ]);

        //Act & Assert
        $this->assertEquals('Pepe Viyuela', $usuario->getFullName());
    }

    /**
     * Test de integridad
     * @test
     */
    public function T03_create_should_throw_exception_on_duplicate_email()
    {
        //arrange
        Usuario::create([
            'name' => 'User 1',
            'apellidos' => 'Test',
            'email' => 'repetido@example.com',
            'password' => 'secret',
            'dni' => '11111111A'
        ]);

        // Assert
        $this->expectException(QueryException::class);

        //act
        Usuario::create([
            'name' => 'User 2',
            'apellidos' => 'Test',
            'email' => 'repetido@example.com',
            'password' => 'secret',
            'dni' => '22222222B'
        ]);
    }
}

