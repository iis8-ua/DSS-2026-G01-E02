<?php

namespace Tests\Feature;

use App\Models\Horario;
use App\Models\Localizacion;
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
        $tipo = TipoEspacio::create(['nombre' => 'Laboratorio']);

        $loc1 = Localizacion::create(['latitud' => 10.0, 'longitud' => 10.0, 'piso' => 1]);
        $loc2 = Localizacion::create(['latitud' => 20.0, 'longitud' => 20.0, 'piso' => 2]);

        $hor=Horario::create(['inicio' => '08:00:00', 'fin' => '10:00:00']);

        $espacio1 = Espacio::create([
            'nombre' => 'Lab 1',
            'aforo' => 15,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc1->latitud,
            'loc_longitud' => $loc1->longitud,
            'loc_piso' => $loc1->piso,
            'horario_inicio' => '2026-02-27 08:00:00',
            'horario_fin' => '2026-02-27 10:00:00',
        ]);

        $espacio2 = Espacio::create([
            'nombre' => 'Lab 2',
            'aforo' => 20,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc2->latitud,
            'loc_longitud' => $loc2->longitud,
            'loc_piso' => $loc2->piso,
            'horario_inicio' => $hor->inicio,
            'horario_fin' => $hor->fin,
        ]);

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
        $tipo = TipoEspacio::create(['nombre' => 'Despacho']);
        $loc = Localizacion::create(['latitud' => 5.0, 'longitud' => 5.0, 'piso' => 0]);
        $hor=Horario::create(['inicio' => '08:00:00', 'fin' => '10:00:00']);

        Espacio::create([
            'nombre' => 'Despacho 1',
            'aforo' => 2,
            'tipo_espacio_id' => $tipo->id,
            'loc_latitud' => $loc->latitud,
            'loc_longitud' => $loc->longitud,
            'loc_piso' => $loc->piso,
            'horario_inicio' => $hor->inicio,
            'horario_fin' => $hor->fin,
        ]);

        //Assert
        $this->expectException(\Illuminate\Database\QueryException::class);

        //Act
        $tipo->delete();
    }
}
