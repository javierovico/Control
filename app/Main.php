<?php


namespace App;


use App\ModelosBaseDato\Empleado;
use App\ModelosBaseDato\Registro;

class Main{
    public static function recorrer(){
        $empleadosTardios = array();
        $marcacionesArray = Marcacion::leerMarcaciones();       //optiene en un array todas las marcaciones del dia
        foreach ($marcacionesArray as $marcacion){              //recorre el array para validar las llegadas tardias
            $empleado = $marcacion->empleado;                   //optiene el empleado de la marcacion
            $fechaMarcada = $marcacion->fechaHoraMarcacion;     //optiene la fecha de marcacion
            if($empleado instanceof Validable){                 //pregunta si el empleado puede ser validado (los unicos que pueden ser validados son los Directores y PersonalServicio
                if($empleado->validar($fechaMarcada)){          //Pregunta si llego tarde
                    if(!isset($empleadosTardios[$empleado->legajo])){           //pregunta si el empleado ya se cargo en el Map
                        $empleadosTardios[$empleado->legajo] = $empleado;       //sino, lo agrega
                    }
                    $empleadosTardios[$empleado->legajo]->cantidadLlegadasTardias++;    //aumenta sus llegadas tardias
                }
            }else{  //el unico que no es validable es el gerente

            }
            /** Ahora independientemente si el empleado llego tarde o no, se guarda en el registro de la base de datos **/
            $empleado->guardarseEnBase();
            $registro = new Registro([
                ''
            ]);

        }
    }
}
