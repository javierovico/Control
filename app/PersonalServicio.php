<?php


namespace App;


use phpDocumentor\Reflection\Types\Boolean;

class PersonalServicio extends Empleado implements Validable {
    public $cantidadLlegadasTardias = 0;
    public $cobraInsalubridad = false;
    public $montoInsalubridad = 0;

    /**
     * Estas constantes son para la personalizacion de los "atributos" de un empleado (en este caso director, personal, etc)
     */
    public const PARAMETRO_LLEGADAS_TARDIA = 'llegadas_tardias';
    public const PARAMETRO_COBRA_INSALUBRIDAD = 'cobra_insalubridad';
    public const PARAMETRO_MONTO_INSALUBRIDAD = 'monto_insalubridad';

    /**
     * PersonalServicio constructor.
     */
    public function __construct($nombre,$apellido,$legajo)
    {
        parent::__construct($nombre,$apellido,$legajo,false,0,Empleado::TIPO_PERSONAL_SERVICIO,[
            self::PARAMETRO_LLEGADAS_TARDIA => '0',
            self::PARAMETRO_COBRA_INSALUBRIDAD => '0',
            self::PARAMETRO_MONTO_INSALUBRIDAD => '0'
        ]);
    }

    /**
     * @return int
     */
    public function getCantidadLlegadasTardias(): int
    {
        return $this->cantidadLlegadasTardias;
    }

    /**
     * @param int $cantidadLlegadasTardias
     */
    public function setCantidadLlegadasTardias(int $cantidadLlegadasTardias): void
    {
        $this->cantidadLlegadasTardias = $cantidadLlegadasTardias;
    }

    /**
     * @return bool
     */
    public function isCobraInsalubridad(): bool
    {
        return $this->cobraInsalubridad;
    }

    /**
     * @param bool $cobraInsalubridad
     */
    public function setCobraInsalubridad(bool $cobraInsalubridad): void
    {
        $this->cobraInsalubridad = $cobraInsalubridad;
    }

    /**
     * @return int
     */
    public function getMontoInsalubridad(): int
    {
        return $this->montoInsalubridad;
    }

    /**
     * @param int $montoInsalubridad
     */
    public function setMontoInsalubridad(int $montoInsalubridad): void
    {
        $this->montoInsalubridad = $montoInsalubridad;
    }

    public function validar($hora): bool
    {
        $maximaTolerancia = new \DateTime( Marcacion::HORARIO_ENTRADA);  //solo vamos a tomar as horas y minutos
        $maximaTolerancia = $maximaTolerancia->format('H:i');       //convertir a string formateado
        return ((date('H:i',strtotime($hora))) > ( $maximaTolerancia ));
    }


}
