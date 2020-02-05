<?php


namespace App;


use phpDocumentor\Reflection\Types\Boolean;

class Director extends Empleado implements Validable {
    public $cantidadLlegadasTardias = 0;
    public $departamento = null;
    public $cantidadSubordinados = 0;

    /**
     * Director constructor.
     */
    public function __construct($nombre, $apellido, $legajo)
    {
        parent::__construct($nombre,$apellido,$legajo,true,5);
    }

    public function validar($fecha): bool
    {
        $maximaTolerancia = new \DateTime('2000-01-01 ' . Marcacion::HORARIO_ENTRADA);  //solo vamos a tomar as horas y minutos
        if($this->tieneTolerancia){
            $maximaTolerancia->add(new \DateInterval('PT' . $this->minutosTolerancia . 'M'));
        }
        $maximaTolerancia = $maximaTolerancia->format('H:m');
        return ((date('H:m',strtotime($fecha))) > ( $maximaTolerancia ));
    }
}
