<?php


namespace App;


use phpDocumentor\Reflection\Types\Boolean;

class PersonalServicio extends Empleado implements Validable {
    public $cantidadLlegadasTardias = 0;
    public $cobraInsalubridad = false;
    public $montoInsalubridad = 0;

    /**
     * PersonalServicio constructor.
     */
    public function __construct($nombre,$apellido,$legajo)
    {
        parent::__construct($nombre,$apellido,$legajo,false,0);
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

    public function validar($fecha): bool
    {
        $maximaTolerancia = new \DateTime('2000-01-01 ' . Marcacion::HORARIO_ENTRADA);  //solo vamos a tomar as horas y minutos
        $maximaTolerancia = $maximaTolerancia->format('H:m');
        return ((date('H:m',strtotime($fecha))) > ( $maximaTolerancia ));
    }
}
