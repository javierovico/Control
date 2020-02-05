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

    public function validar($fecha): bool
    {
        $maximaTolerancia = new \DateTime('2000-01-01 ' . Marcacion::HORARIO_ENTRADA);  //solo vamos a tomar as horas y minutos
        $maximaTolerancia = $maximaTolerancia->format('H:m');
        return ((date('H:m',strtotime($fecha))) > ( $maximaTolerancia ));
    }
}
