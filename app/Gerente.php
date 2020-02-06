<?php


namespace App;


class Gerente extends Empleado {
    public $sobresueldo = 0;
    public $area = null;

    /**
     * Estas constantes son para la personalizacion de los "atributos" de un empleado (en este caso director, personal, etc)
     */
    public const PARAMETRO_SOBRESUELDO = 'sobresueldo';
    public const PARAMETRO_AREA = 'area';

    /**
     * @return int
     */
    public function getSobresueldo(): int
    {
        return $this->sobresueldo;
    }

    /**
     * @param int $sobresueldo
     */
    public function setSobresueldo(int $sobresueldo): void
    {
        $this->sobresueldo = $sobresueldo;
    }

    /**
     * @return null
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param null $area
     */
    public function setArea($area): void
    {
        $this->area = $area;
    }

    /**
     * Gerente constructor.
     * @param int $sobresueldo
     */
    public function __construct($nombre,$apellido,$legajo)
    {
        parent::__construct($nombre,$apellido,$legajo,false,0,Empleado::TIPO_GERENTE,[
            self::PARAMETRO_SOBRESUELDO => '0',
            self::PARAMETRO_AREA => '',
        ]);
    }


}
