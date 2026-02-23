<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TipoEspacio;
use App\Models\Espacio;
use Illuminate\Database\Eloquent\Collection;

class TipoEspacioTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test de la relacion con los espacios ya que un tipo puede tener muchos espacios
     * @test
     */
    public function T01_espacios_should_return_CollectionOfEspacio_when_tipo_has_espacios()
    {
        //Arrange
        $tipo=TipoEspacio::factory()->create();
        $espacio1 = Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);
        $espacio2 = Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);

        //Act
        $resultado = $tipo->espacios;

        //Assert
        $this->assertInstanceOf(Collection::class, $resultado);
        $this->assertCount(2, $resultado);
        $this->assertTrue($resultado->contains($espacio1));
        $this->assertTrue($resultado->contains($espacio2));
        $this->assertInstanceOf(Espacio::class, $resultado->first());

    }

    /***
     * Test para validar que no se puede eliminar un tipo si tiene espacios
     * @test
     */
    public function T02_delete_should_throwException_when_tipo_has_espacios_assigned()
    {
        //Arrange
        $tipo = TipoEspacio::factory()->create();
        Espacio::factory()->create(['tipo_espacio_id' => $tipo->id]);

        //Assert
        $this->expectException(\Illuminate\Database\QueryException::class);

        //Act
        $tipo->delete();
    }
}
