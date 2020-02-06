<?php

namespace App\ModelosBaseDato;

use Illuminate\Database\Eloquent\Model;

class ParametroEmpleado extends Model
{
    protected $primaryKey = ['legajo_id','parametro'];
    protected $fillable = ['legajo_id','parametro','valor'];
    public $incrementing = false;
    public $timestamps = false;
}
