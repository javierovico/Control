<?php


namespace App;


use App\ModelosBaseDato\ParametroEmpleado;
use Illuminate\Database\Eloquent\Model;

class Empleado implements GuardadoEnBase {

    public $nombre = null;
    public $apellido = null;
    public $legajo = null;
    public $tieneTolerancia = false;
    public $minutosTolerancia = 0;

    private $tipoEmpleado = 0;  //para saber que tipo de empleado es (1->gerente, 2->personalservicio, 3->director)


    public const TIPO_GERENTE = 1;
    public const TIPO_PERSONAL_SERVICIO = 2;
    public const TIPO_DIRECTOR = 3;

    public $parametros = array();

    /**
     * @return array
     */
    public function getParametros(): array
    {
        return $this->parametros;
    }

    /**
     * @param array $parametros
     */
    public function setParametros(array $parametros): void
    {
        $this->parametros = $parametros;
    }   //para que cada tipo de empleado maneje sus parametros desde aca nomas en vez de implementar en cada clase


    /**
     * @return null
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param null $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return null
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param null $apellido
     */
    public function setApellido($apellido): void
    {
        $this->apellido = $apellido;
    }

    /**
     * @return null
     */
    public function getLegajo()
    {
        return $this->legajo;
    }

    /**
     * @param null $legajo
     */
    public function setLegajo($legajo): void
    {
        $this->legajo = $legajo;
    }

    /**
     * @return bool
     */
    public function isTieneTolerancia(): bool
    {
        return $this->tieneTolerancia;
    }

    /**
     * @param bool $tieneTolerancia
     */
    public function setTieneTolerancia(bool $tieneTolerancia): void
    {
        $this->tieneTolerancia = $tieneTolerancia;
    }

    /**
     * @return int
     */
    public function getMinutosTolerancia(): int
    {
        return $this->minutosTolerancia;
    }

    /**
     * @param int $minutosTolerancia
     */
    public function setMinutosTolerancia(int $minutosTolerancia): void
    {
        $this->minutosTolerancia = $minutosTolerancia;
    }

    /**
     * Empleado constructor.
     * @param null $nombre
     * @param null $apellido
     * @param null $legajo
     */
    public function __construct($nombre, $apellido, $legajo, $tieneTolerancia , $minutosTolerancia,$tipoEmpleado,$parametros)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->legajo = $legajo;
        $this->tieneTolerancia = $tieneTolerancia;
        $this->minutosTolerancia = $minutosTolerancia;
        $this->tipoEmpleado = $tipoEmpleado;
        $this->parametros = $parametros;
    }


    /**
     * @inheritDoc
     */
    public function guardarseSiNoExiste(): bool
    {
        $empleado = $this->retornarInstanciaBD();
        if($empleado == null){              //el empleado todavia no existe
            $empleado = new \App\ModelosBaseDato\Empleado([
                'legajo' => $this->getLegajo(),
                'nombre' => $this->getNombre(),
                'apellido' => $this->getApellido(),
                'tiene_tolerancia' => $this->isTieneTolerancia(),
                'minutos_tolerancia' => $this->getMinutosTolerancia(),
                'tipo_empleado_id' => $this->tipoEmpleado,
            ]);
            $empleado->save();  //lo guarda
            //recorremos sus parametros (SI EXISTEN)
            foreach ($this->parametros as $parametro=>$valor){
                $parametroBD = new ParametroEmpleado([
                    'legajo_id' => $this->legajo,
                    'parametro' => $parametro,
                    'valor'     => $valor
                ]);
                $parametroBD->save();
            }
            return true;
        }else{
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function retornarInstanciaBD()
    {
        return \App\ModelosBaseDato\Empleado::where('legajo','=',$this->legajo)->first();
    }
}
