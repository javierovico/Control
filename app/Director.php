<?php


namespace App;
use App\Empleado;


class Director extends Empleado implements Validable {
    public $cantidadLlegadasTardias = 0;
    public $departamento = null;
    public $cantidadSubordinados = 0;

    /**
     * Estas constantes son para la personalizacion de los "atributos" de un empleado (en este caso director, personal, etc)
     */
    public const PARAMETRO_LLEGADAS_TARDIA = 'llegadas_tardias';
    public const PARAMETRO_DEPARTAMENTO = 'departamento';
    public const PARAMETRO_CANTIDAD_SUBORDINADOS = 'cantidad_subordinados';

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
     * @return null
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param null $departamento
     */
    public function setDepartamento($departamento): void
    {
        $this->departamento = $departamento;
    }

    /**
     * @return int
     */
    public function getCantidadSubordinados(): int
    {
        return $this->cantidadSubordinados;
    }

    /**
     * @param int $cantidadSubordinados
     */
    public function setCantidadSubordinados(int $cantidadSubordinados): void
    {
        $this->cantidadSubordinados = $cantidadSubordinados;
    }

    /**
     * Director constructor.
     */
    public function __construct($nombre, $apellido, $legajo)
    {
        parent::__construct($nombre,$apellido,$legajo,true,5,Empleado::TIPO_DIRECTOR,[
            self::PARAMETRO_LLEGADAS_TARDIA => '0',
            self::PARAMETRO_DEPARTAMENTO => '',
            self::PARAMETRO_CANTIDAD_SUBORDINADOS => '0'
        ]);
    }

    public function validar($hora): bool
    {
        $maximaTolerancia = new \DateTime( Marcacion::HORARIO_ENTRADA);  //solo vamos a tomar as horas y minutos
        if($this->tieneTolerancia){
            $maximaTolerancia->add(new \DateInterval('PT' . $this->minutosTolerancia . 'M'));
        }
        $maximaTolerancia = $maximaTolerancia->format('H:i');
        return ((date('H:i',strtotime($hora))) > ( $maximaTolerancia ));
    }
}
