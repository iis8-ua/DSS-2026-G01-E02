<?php
namespace App\Models;
use App\Models\Usuario;
use App\Models\Reserva;
use App\Models\Espacio;
use App\Models\ReservaGrupal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alumno extends Usuario{
    protected static function boot(){
        parent::boot();

        //global scope para poner  solo lo de los alumnos
        static::addGlobalScope('alumnos', function(Builder $builder){
            $builder->where('tipo_usuario', self::class);
        });

        static::creating(function ($model) {
            $model->tipo_usuario = self::class;
        });

    }
    public function reservas(): HasMany{
            return $this->hasMany(Reserva::class, 'user_id');
    }

        public function reservasGrupales(): BelongsToMany{
            return $this->belongsToMany(ReservaGrupal::class, 'alumno_reserva_grupal', 'alumno_id', 'reserva_id');
    }

    public function reservar(Espacio $espacio, $fechaInicio, $fechaFin): Reserva{
        $reserva = new Reserva();
        $reserva->user_id = $this->id;
        $reserva->espacio_id = $espacio->id;
        $reserva->fecha_inicio = $fechaInicio;
        $reserva->fecha_fin = $fechaFin;
        $reserva->estado = 'pendiente';
        
        $reserva->save();

        return $reserva;
    }
}