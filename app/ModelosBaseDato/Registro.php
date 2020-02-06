<?php

namespace App\ModelosBaseDato;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $fillable = ['legajo','fecha','tardio','minutos_tarde'];   //para poder agregarse
    public $timestamps = false;
}
