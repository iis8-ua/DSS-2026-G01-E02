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
        'tipo_espacio_id'
    ];

    protected $casts = ['estado' => EstadoEspacio::class,];

    /**
     * Relacion con localización
     */
    public function loacalizacion()
    {
        return $this->belongsTo(Localizacion::class, 'loc_latitud', 'latitud')
                    ->where('loc_longitud', '=', 'longitud')
                    ->where('loc_piso', '=', 'piso');
    }

    /***
     * Relacion con TipoEspacio
     */
    public function tipo()
    {
        return $this->belongsTo(TipoEspacio::class, 'tipo_espacio_id');
    }
}
