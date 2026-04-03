<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Enums\EstadoEspacio;

class Espacio extends Model
{
    use HasUuids;

    protected $table = 'espacios';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'aforo',
        'estado',
        'caracteristicas',
        'localizacion_id',
        'tipo_espacio_id',
        'imagen'
    ];

    //Para castear el estado al enumerado
    protected $casts = [
        'estado' => EstadoEspacio::class,
    ];

    /**
     * Relacion con localización, tiene que tener una obligatoria
     */
    public function localizacion()
    {
        return $this->belongsTo(Localizacion::class, 'localizacion_id');
    }

    /***
     * Relacion con TipoEspacio, tiene que tener un tipo obligatorio
     */
    public function tipo()
    {
        return $this->belongsTo(TipoEspacio::class, 'tipo_espacio_id');
    }

    /**
     * Relacion con Horario, el espacio tiene que tener obligatoriamente un horario
     */
    public function horario()
    {
        return $this->belongsToMany(Horario::class, 'espacio_horario');
    }


}
