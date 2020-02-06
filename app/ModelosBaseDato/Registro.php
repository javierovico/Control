<?php

namespace App\ModelosBaseDato;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $fillable = ['legajo','fecha','hora','tardio','minutos_tarde'];   //para poder agregarse
    public $timestamps = false;
}
