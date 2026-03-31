<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Builder;

class Admin extends Usuario{
    protected $table = 'usuarios';
    protected static function boot(){
        parent::boot();

        static::addGlobalScope('admins', function(Builder $builder){
            $builder->where('tipo_usuario', 'ADMIN');
        });

        static::creating(function ($model) {
            $model->tipo_usuario = 'ADMIN';
        });

    }
}
