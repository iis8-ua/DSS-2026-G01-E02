<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaGrupal extends Model{
    use HasFactory;

    // La clave primaria es reserva_id y no autoincremental
    protected $primaryKey = 'reserva_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['reserva_id', 'aforo_max'];

    // relación inversa con Reserva
    // reserva es el padre
    public function reserva(){
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    //relacion con el alumno para ver los miembros del grupo que es muchos a muchos
    public function alumnos(){
        return $this->belongsToMany(
            Alumno::class,
            'alumno_reserva_grupal',
            'reserva_grupal_id',
            'alumno_id'
        )->withTimestamps();
    }

    //Para añadir alumnos a la reserva
    public function addAlumno(Alumno $alumno) {
        $this->alumnos()->attach($alumno->id);
    }

    //eliminar alumnos de la reserva
    public function removeAlumno(Alumno $alumno) {
        $this->alumnos()->detach($alumno->id);
    }
}
