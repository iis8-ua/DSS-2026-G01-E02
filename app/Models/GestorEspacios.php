<?php
namespace App\Models;
use App\Enums\EstadoReserva;
use App\Models\Usuario;
use App\Models\Reserva;
use App\Models\Espacio;
use Illuminate\Database\Eloquent\Builder;

class GestorEspacios extends Usuario{
    protected $table = 'usuarios';
    protected static function boot(){
        parent::boot();

        //global scope para poner solo lo de los gestores de espacios
        static::addGlobalScope('gestores_espacios', function(Builder $builder){
            $builder->where('tipo_usuario', self::class);
        });

        static::creating(function ($model) {
            $model->tipo_usuario = self::class;
        });

    }


    //metodos
    public function aceptarReserva(Reserva $reserva): void{
        $reserva->estado = EstadoReserva::ACEPTADA;
        $reserva->save();
    }

    public function rechazarReserva(Reserva $reserva): void{
        $reserva->estado = EstadoReserva::RECHAZADA;
        $reserva->save();
    }
}
