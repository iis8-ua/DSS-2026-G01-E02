<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Enums\EstadoReserva;
use App\Models\Usuario;
use App\Models\Espacio;
use App\Models\Horario;

class Reserva extends Model{
    use HasFactory, HasUuids;

    // ID no autoincremental
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'espacio_id',
        'alumno_id',
        'hora_inicio',
        'hora_fin',
        'estado'];

    // Relación con el detalle grupal
    public function reservaGrupal(){
        return $this->hasOne(ReservaGrupal::class, 'reserva_id');
    }

    // usuario asociado a la reserva
    public function alumno(){
        return $this->belongsTo(Usuario::class, 'alumno_id');
    }

    // espacio asociado a la reserva
    public function espacio(){
        return $this->belongsTo(Espacio::class);
    }


    protected function casts(): array{
        return [
            'hora_inicio' => 'datetime',
            'hora_fin' => 'datetime',
            'estado' => EstadoReserva::class,
        ];
    }

    //para cancelar una reserva
    public function cancelar() {
        $this->estado = 'CANCELADA';
        $this->save();
    }

    //abrir una reserva
    public function abrirReserva() {
        $this->estado = 'ACEPTADA';
        $this->save();
    }
}
