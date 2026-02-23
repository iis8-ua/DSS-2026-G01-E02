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
    //metodos del usuario
    public function getDNI(): string{
        return (string) $this->dni;
    }
    //get nombre completo
    public function getFullName(): string {
        return $this->name . ' ' . $this->apellidos;
    }
    //get email
    public function getEmail(): string{
        return (string) $this->email;
    }
    public function setEmail(string $email): void{
        $this->email = $email;
    }
    public function setPassword(string $email): void{
        $this->password = $password;
        $this->save();
    }
}
