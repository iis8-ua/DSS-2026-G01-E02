<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Representa una notificación a un usuario.
 * 
 * Puede estar asociada opcionalmente a una incidencia.
 */
class Notificacion extends Model
{
    public $uuid = null;
    // Texto que aparece en la notificación
    public $texto = "";
    // Estado de la notificación (vista/no vista)
    public $vista = false;
    // Incidencia relacionada
    public $incidencia = null;
    // Usuario destino
    public $usuario = null;

    public function __construct($texto, $usuario){
        $this->texto = $texto;
        $this->usuario = $usuario;
        $this->incidencia = null;
        $this->vista = false;
    }

}

