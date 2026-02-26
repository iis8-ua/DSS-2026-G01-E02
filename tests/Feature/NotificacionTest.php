<?php

namespace Tests\Feature;

use App\Models\Notificacion;
use App\Models\Incidencia;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificacionTest extends TestCase
{
    use RefreshDatabase;
    protected $incidencia;
    protected function setUp(): void
    {
        parent::setUp();
        $this->incidencia = Incidencia::create([
            'descripcion' => 'Descripción de prueba'
        ]);

        
    }

    /** @test */
    public function c1_hasIncidencia_should_return_false_when_no_incidence(): void
    {
        // Arrange: inicializamos los datos
        
        $notificacion = Notificacion::create([
            'texto'=> 'Notificación de testing'
        ]);
        // Act: obtenemos los resultados
        $resultado = $notificacion->hasIncidencia();
        // Assert
        $this->assertFalse($resultado);
    }

    /** @test */
    public function c2_hasIncidencia_returns_true_when_incidence_exists(): void
    {
        // Arrange: creamos una incidencia y la vinculamos
        $notificacion = Notificacion::create([
            'texto' => 'Notificación de testing',
            'incidencia_id' => $this->incidencia->id,
        ]);

        // Act
        $resultado = $notificacion->hasIncidencia();

        // Assert
        $this->assertTrue($resultado);
    }

    /** @test */
    public function c3_incident_relation_returns_the_related_model(): void
    {
        // Arrange
        $notificacion = Notificacion::create([
            'texto' => 'Notificación de testing',
            'incidencia_id' => $this->incidencia->id,
        ]);

        // Act
        $relacionada = $notificacion->incidencia;

        // Assert
        $this->assertInstanceOf(Incidencia::class, $relacionada);
        $this->assertEquals($this->incidencia->id, $relacionada->id);
    }
}
