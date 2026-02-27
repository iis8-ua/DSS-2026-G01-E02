<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Notificacion;
use App\Models\Incidencia;
use Illuminate\Database\Eloquent\Collection;

class UsuarioTest extends TestCase
{

use RefreshDatabase;

    /**
     * Test de la relacion con Notificacion
     * @test
     */
    public function T01_notificaciones_should_return_collection_of_Notificacion_when_usuario_has_notificaciones()
    {
        //Arrange
        $usuario = Usuario::create([
            'name' => 'Juan',
            'apellidos' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'password' => 'password',
            'dni' => '12345678A',
            'tipo_usuario' => 'usuario'
        ]);

        $notificacion1 = Notificacion::create([
            'user_id' => $usuario->id,
            'vista' => false,
            'texto' => 'Tu reserva ha sido cancelada'
        ]);
        $notificacion2 = Notificacion::create([
            'user_id' => $usuario->id,
            'vista' => false,
            'texto' => 'Tu reserva ha sido aceptada'
        ]);

        //Act
        //se llama a la relacion
        $resultado = $usuario->notificaciones;

        //Assert
        //nos devuelve una coleccion(lista)
        $this->assertInstanceOf(Collection::class, $resultado);
        //comprobamos que la coleccion tiene 2 notificaciones
        $this->assertCount(2, $resultado);

        $this->assertInstanceOf(Notificacion::class, $resultado->first());

        $this->assertTrue($resultado->contains($notificacion1));
        $this->assertTrue($resultado->contains($notificacion2));
    }

    /**
     * Incidencias
     * @test
     */
    public function T02_incidencias_should_return_collection_of_Incidencia_when_usuario_has_incidencias(){
        //Arrange
        $usuario = Usuario::create([
            'name' => 'Juan',
            'apellidos' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'password' => 'password',
            'dni' => '12345678A',
            'tipo_usuario' => 'usuario'
        ]);

        $incidencia1 = Incidencia::create([
            'user_id' => $usuario->id,
            'estado' => 'abierta',
            'descripcion' => 'El proyector no funciona'
        ]);
        //Act
        //se llama a la relacion
        $resultado = $usuario->incidencias;

        //Assert
        $this->assertInstanceOf(Collection::class, $resultado);
        $this->assertCount(1, $resultado);
        $this->assertInstanceOf(Incidencia::class, $resultado->first());
        $this->assertTrue($resultado->contains($incidencia1));

    }
}

