<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Marcacion implements GuardadoEnBase
{

    const ARCHIVO = "C:/Marcaciones.txt";
    const HORARIO_ENTRADA = '08:00';

    public $fechaMarcacion = null;
    public $horaMarcacion = null;
    public $empleado = null;

    /**
     * @return null
     */
    public function getHoraMarcacion()
    {
        return $this->horaMarcacion;
    }

    /**
     * @param null $horaMarcacion
     */
    public function setHoraMarcacion($horaMarcacion): void
    {
        $this->horaMarcacion = $horaMarcacion;
    }

    /**
     * Marcacion constructor.
     * @param null $fechaMarcacion
     * @param null $empleado
     */
    public function __construct($fechaMarcacion,$horaMarcacion, $empleado)
    {
        $this->fechaMarcacion = $fechaMarcacion;
        $this->horaMarcacion = $horaMarcacion;
        $this->empleado = $empleado;
    }

    /**
     * @return null
     */
    public function getfechaMarcacion()
    {
        return $this->fechaMarcacion;
    }

    /**
     * @param null $fechaMarcacion
     */
    public function setfechaMarcacion($fechaMarcacion): void
    {
        $this->fechaMarcacion = $fechaMarcacion;
    }

    /**
     * @return null
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * @param null $empleado
     */
    public function setEmpleado($empleado): void
    {
        $this->empleado = $empleado;
    }


    /**
     * Lee las marcaciones desde un archivo depositado en C:/Marcaciones.txt
     * y las retorna en un array de marcaciones
     */
    public static function leerMarcaciones() : array {
        $marcacionesArray = array();
        $recurso = fopen(self::ARCHIVO,'r');
        $datosRecogidos = array();  //almacena todos los datos recogidos en bruto del archivo
        while (! feof($recurso)){
            $linea = trim(fgets($recurso));
            $datos = explode("\t",$linea);
            if(count($datos)<6){    //ignora los que tienen menos registros de lo requerido (tambien sirve para que no de errores las lineas vacias)
                continue;
            }
            $datosRecogidos[] = (object)array(
                'fecha' => $datos[0],
                'hora' => $datos[1],
                'legajo' => $datos[2],
                'nombre' => $datos[3],
                'apellido' => $datos[4],
                'tipo' => $datos[5],
            );
        }
        foreach ($datosRecogidos as $datosRecogido){
            $empleado = null;
            switch ($datosRecogido->tipo){
                case 'G':
                    $empleado = new Gerente($datosRecogido->nombre,$datosRecogido->apellido,$datosRecogido->legajo);
                    break;
                case 'D':
                    $empleado = new Director($datosRecogido->nombre,$datosRecogido->apellido,$datosRecogido->legajo);
                    break;
                case 'S':
                    $empleado = new PersonalServicio($datosRecogido->nombre,$datosRecogido->apellido,$datosRecogido->legajo);
                    break;
            }
            $fechaMarcacion = date('Y-m-d',\DateTime::createFromFormat('d/m/Y',$datosRecogido->fecha)->getTimestamp());
            $horaMarcacion = date('H:i',strtotime($datosRecogido->fecha . ' ' . $datosRecogido->hora));
            if(strpos($fechaMarcacion,'1970-')===false){ //fecha correcta
                $marcacionNueva = new Marcacion($fechaMarcacion,$horaMarcacion,$empleado);
                $marcacionesArray[] = $marcacionNueva;
            }
        }
        return $marcacionesArray;
    }

    /**
     * @inheritDoc
     * @throws \Throwable
     */
    public function guardarseSiNoExiste(): bool
    {
        $marcacionBD = $this->retornarInstanciaBD();
        throw_if($marcacionBD != null,new \Exception('esta marcacion esta repetida, no se puede seguir con datos corruptos'));
        $marcacionBD = new \App\ModelosBaseDato\Registro([
            'legajo' => $this->empleado->legajo,
            'fecha'     => $this->fechaMarcacion,
            'hora'      => $this->horaMarcacion,
            'tardio'    => ($this->empleado instanceof Validable)?($this->empleado->validar($this->horaMarcacion)):false,
            'minutos_tarde' => $this->calcularMinutosTarde()
        ]);
        $marcacionBD->save();
        return true;
    }

    /**
     * @inheritDoc
     */
    public function retornarInstanciaBD()
    {
        return \App\ModelosBaseDato\Registro::where('legajo','=',$this->empleado->legajo)->where('fecha','=',$this->fechaMarcacion)->first();
    }

    /**
     * Calcula que tan tarde llego el empleado
     */
    private function calcularMinutosTarde() : int
    {
        if(($this->empleado instanceof Validable) && $this->empleado->validar($this->horaMarcacion)){
            $maximaTolerancia = new \DateTime( Marcacion::HORARIO_ENTRADA);  //solo vamos a tomar as horas y minutos
            if($this->empleado->tieneTolerancia){
                $maximaTolerancia->add(new \DateInterval('PT' . $this->empleado->minutosTolerancia . 'M'));
            }
            $maximaTolerancia = $maximaTolerancia->format('H:i');
            return abs((strtotime($maximaTolerancia) - strtotime($this->horaMarcacion))/60);
        }else{  //no llego tarde (o es el gerente)
            return 0;
        }
    }
}
