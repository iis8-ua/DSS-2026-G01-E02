<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // Importante para UUID

class Reserva extends Model
{
    use HasFactory, HasUuids;

    // ID no autoincremental
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'espacio_id', 
        'user_id', 
        'fecha_hora_inicio', 
        'fecha_hora_fin', 
        'estado'];

    // Relación con el detalle grupal
    public function reservaGrupal(){
        return $this->hasOne(ReservaGrupal::class, 'reserva_id');
    }

    // usuario asociado a la reserva
    public function user(){
        return $this->belongsTo(User::class);
    }

    // espacio asociado a la reserva
    public function espacio(){
        return $this->belongsTo(Espacio::class);
    }
}