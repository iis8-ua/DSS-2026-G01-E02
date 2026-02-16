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
    private $uuid = null;
    // Texto que aparece en la notificación
    private $texto = "";
    // Estado de la notificación (vista/no vista)
    private $vista = false;
    // Incidencia relacionada
    private $incidencia = null;
    // Usuario destino
    private $usuario = null;

    public function __construct($texto, $usuario){
        $this->texto = $texto;
        $this->usuario = $usuario;
        $this->incidencia = null;
        $this->vista = false;
    }

    public function setIncidencia($incidencia): void {
        $this->incidencia = $incidencia;
    }

    public function getIncidencia(): Incidencia {
        return $this->incidencia;
    }

    public function getUsuario(): Usuario {
        return $this->usuario;
    }

    public function setVista($vista): void{
        $this->vista = $vista;
    }

    public function vista(): bool {
        return $this->vista;
    }
}

