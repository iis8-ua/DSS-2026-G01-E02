<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localizacion extends Model
{
    protected $table = 'localizacions';

    //para que no se incremente ya que no es un id
    public $incrementing = false;

    //aqui se le dice que la clave primaria no es un entero como espera ya que no es un id
    protected $keyType = 'array';

    protected $fillable = ['latitud', 'longitud', 'piso'];

    /**
     * Se sobreescribe el metodo de Laravel para indicarle que la clave primaria es una combinacion
     */
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('latitud', '=', $this->getAttribute('latitud'))
            ->where('longitud', '=', $this->getAttribute('longitud'))
            ->where('piso', '=', $this->getAttribute('piso'));

        return $query;
    }
}
