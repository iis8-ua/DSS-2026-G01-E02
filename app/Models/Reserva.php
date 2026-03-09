<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Enums\EstadoReserva;

class Reserva extends Model{
    use HasFactory, HasUuids;

    // ID no autoincremental
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'espacio_id',
        'user_id',
        'fecha_inicio',
        'fecha_fin',
        'estado'];

    // Relación con el detalle grupal
    public function reservaGrupal(){
        return $this->hasOne(ReservaGrupal::class, 'reserva_id');
    }

    // usuario asociado a la reserva
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    // espacio asociado a la reserva
    public function espacio(){
        return $this->belongsTo(Espacio::class);
    }

    //relacion con el horario
    public function horario(): ?Horario{
        return Horario::where('inicio', $this->fecha_inicio)
            ->where('fin', $this->fecha_fin)
            ->first();
    }

    protected function casts(): array{
        return [
            'fecha_inicio' => 'datetime',
            'fecha_fin' => 'datetime',
            'estado' => EstadoReserva::class,
        ];
    }
}
