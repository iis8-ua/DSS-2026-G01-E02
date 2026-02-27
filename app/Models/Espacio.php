<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Enums\EstadoEspacio;

class Espacio extends Model
{
    use HasUuids;

    protected $table = 'espacios';

    protected $fillable = [
        'nombre',
        'aforo',
        'estado',
        'caracteristicas',
        'loc_latitud',
        'loc_longitud',
        'loc_piso',
        'tipo_espacio_id',
        'horario_inicio',
        'horario_fin',
    ];

    //Para castear el estado al enumerado y los horarios a DateTime
    protected $casts = ['estado' => EstadoEspacio::class,
                        'horario_inicio' => 'datetime',
                        'horario_fin' => 'datetime',];

    /**
     * Relacion con localización, tiene que tener una obligatoria
     */
    public function localizacion()
    {
        return $this->belongsTo(Localizacion::class, 'loc_latitud', 'latitud')
                    ->where('longitud', '=', $this->loc_longitud)
                    ->where('piso', '=', $this->loc_piso);
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
        return $this->belongsTo(Horario::class, 'horario_inicio', 'inicio')
            ->where('fin', $this->horario_fin);
    }


}
