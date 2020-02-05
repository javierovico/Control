<?php

namespace App\ModelosBaseDato;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{

    protected $fillable = ['legajo','nombre','apellido','tieneTolerancia','minutosTolerancia','user_id'];   //para poder agregarse
    public $timestamps = false;
    /**
     * conexion con su clase padre
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(){
        return $this->hasOne('App\User');
    }
}
