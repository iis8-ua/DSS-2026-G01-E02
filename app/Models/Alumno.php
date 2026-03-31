<?php
namespace App\Models;
use App\Enums\EstadoReserva;
use App\Models\Usuario;
use App\Models\Reserva;
use App\Models\Espacio;
use App\Models\ReservaGrupal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alumno extends Usuario{
    protected $table = 'usuarios';
    protected static function boot(){
        parent::boot();

        //global scope para poner  solo lo de los alumnos
        static::addGlobalScope('alumnos', function(Builder $builder){
            $builder->where('tipo_usuario', 'ALUMNO');
        });

        static::creating(function ($model) {
            $model->tipo_usuario = 'ALUMNO';
        });

    }

    public function reservasGrupales(): BelongsToMany{
        return $this->belongsToMany(ReservaGrupal::class, 'alumno_reserva_grupal', 'alumno_id', 'reserva_grupal_id');
    }

    public function reservar(Espacio $espacio, $horaInicio, $horaFin): Reserva{
        $reserva = new Reserva();

        $reserva->alumno_id = $this->id;
        $reserva->espacio_id = $espacio->id;
        $reserva->hora_inicio = $horaInicio;
        $reserva->hora_fin = $horaFin;

        $reserva->estado = EstadoReserva::PENDIENTE;

        $reserva->save();

        return $reserva;
    }

    public function obtenerHistorial()
    {
        return Reserva::where('alumno_id', $this->id)->orderBy('hora_inicio', 'desc')->get();
    }
}
