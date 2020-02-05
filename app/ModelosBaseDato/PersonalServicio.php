<?php

namespace App\ModelosBaseDato;

use Illuminate\Database\Eloquent\Model;

class PersonalServicio extends Model
{


    protected $fillable = ['empleado_id','cantidadLlegadasTardias','cobraInsalubridad','montoInsalubridad'];   //para poder agregarse
    public $timestamps = false;
    /**
     * conexion con su clase padre
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function empleado(){
        return $this->hasOne('App\Empleado');
    }
}
