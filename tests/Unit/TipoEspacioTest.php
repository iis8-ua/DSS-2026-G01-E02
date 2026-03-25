<?php

namespace Tests\Unit;

use App\Models\Espacio;
use App\Models\Localizacion;
use App\Models\TipoEspacio;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TipoEspacioTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para asegurar que el UUID y el nombre funcionan
     * @test
     */
    public function T01_create_should_persist_tipo_espacio_correctly()
    {
        // Arrange & Act
        $tipo = TipoEspacio::create(['nombre' => 'Aula de Informática']);

        // Assert
        $this->assertNotNull($tipo->id);
        $this->assertEquals('Aula de Informática', $tipo->nombre);
    }


    /***
     * Test para validar que no se puede eliminar un tipo si tiene espacios
     * @test
     */
    public function T02_delete_should_throwException_when_tipo_has_espacios_assigned()
    {
        //Arrange
        $tipo = TipoEspacio::create(['nombre' => 'Laboratorio']);
        $loc = Localizacion::create(['latitud' => 1.0, 'longitud' => 1.0, 'piso' => 1]);

        Espacio::create([
            'nombre'          => 'Espacio de prueba',
            'aforo'           => 10,
            'estado'          => 'HABILITADO',
            'tipo_espacio_id' => $tipo->id,
            'localizacion_id' => $loc->id,
        ]);

        //Act y Assert
        $this->expectException(QueryException::class);
        $tipo->delete();
    }
}
