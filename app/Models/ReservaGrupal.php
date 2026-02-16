<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaGrupal extends Model
{
    use HasFactory;

    // La clave primaria es reserva_id y no autoincremental
    protected $primaryKey = 'reserva_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['reserva_id', 'aforo_max'];

    // relación inversa con Reserva
    // reserva es el padre
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    // relación Muchos a Muchos para los miembros del grupo.
    public function miembros()
    {
        return $this->belongsToMany(User::class, 'reserva_grupal_user', 'reserva_grupal_id', 'user_id')
                    ->withTimestamps();
    }
}