<?php


namespace App;


class Gerente extends Empleado {
    public $sobresueldo = 0;
    public $area = null;

    /**
     * Gerente constructor.
     * @param int $sobresueldo
     */
    public function __construct($nombre,$apellido,$legajo)
    {
        parent::__construct($nombre,$apellido,$legajo,false,0);
    }


}
