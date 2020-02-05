<?php

namespace App\ModelosBaseDato;

use Illuminate\Database\Eloquent\Model;

class Gerente extends Model
{

    protected $fillable = ['empleado_id','sobresueldo','area'];   //para poder agregarse
    public $timestamps = false;
    /**
     * conexion con su clase padre
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function empleado(){
        return $this->hasOne('App\Empleado');
    }
}
