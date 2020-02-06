<?php


namespace App;


use phpDocumentor\Reflection\Types\Boolean;

interface Validable{
    /**
     * @return bool Deve devolver true si se llego tarde?
     */
    public function validar($hora) : bool;
}
