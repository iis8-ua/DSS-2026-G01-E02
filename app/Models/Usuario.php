<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Concers\HasUuids;

class Usuario extends User{
    use HasUuids;
    protected $table = 'usuarios';

    protected $fillable = [
        'id',
        'name',
        'apellidos',
        'email',
        'password',
        'dni'
        
    ];

    //se inicializa el modelo y la herencia a sigle
    protected static function boot()
    {
        parent::boot();

        // Asignar el tipo de usuario automáticamente al crear un nuevo usuario
        static::creating(function ($model) {
            if ($empty($model->tipo_usuario)) {
                $model->tipo_usuario = self::class;
            }
        });
    }
    //get nombre completo
    public function getFullName(): string {
        return $this->name . ' ' . $this->apellidos;
    }
    
}
