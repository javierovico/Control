<?php


namespace App;


class Marcacion
{

    const ARCHIVO = "C:/Marcaciones.txt";
    const HORARIO_ENTRADA = '08:00';
    public $fechaHoraMarcacion = null;
    public $empleado = null;

    /**
     * Marcacion constructor.
     * @param null $fechaHoraMarcacion
     * @param null $empleado
     */
    public function __construct($fechaHoraMarcacion, $empleado)
    {
        $this->fechaHoraMarcacion = $fechaHoraMarcacion;
        $this->empleado = $empleado;
    }

    /**
     * @return null
     */
    public function getFechaHoraMarcacion()
    {
        return $this->fechaHoraMarcacion;
    }

    /**
     * @param null $fechaHoraMarcacion
     */
    public function setFechaHoraMarcacion($fechaHoraMarcacion): void
    {
        $this->fechaHoraMarcacion = $fechaHoraMarcacion;
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
    public static function leerMarcaciones(){
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
            $fecha = date('Y-m-d H:m',strtotime($datosRecogido->fecha . ' ' . $datosRecogido->hora));
            if(strpos($fecha,'1970-')===false){ //fecha correcta
                $marcacionNueva = new Marcacion($fecha,$empleado);
                $marcacionesArray[] = $marcacionNueva;
            }
        }
        return $marcacionesArray;
    }

}
