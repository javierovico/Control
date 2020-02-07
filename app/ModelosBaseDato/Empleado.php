<?php

namespace App\ModelosBaseDato;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{

    protected $primaryKey = 'legajo';
    public $incrementing = false;
    protected $keyType = 'integer';
    protected $fillable = ['legajo','nombre','apellido','tiene_tolerancia','minutos_tolerancia','tipo_empleado_id'];   //para poder agregarse
    public $timestamps = false;
    /**
     * conexion con su clase padre
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(){
        return $this->hasOne('App\User');
    }

    public function atributos(){
        return $this->hasMany('App\ModelosBaseDato\ParametroEmpleado','legajo_id','legajo');
    }
}
