<?php


namespace App;


class Main{
    public static function recorrer(){
        $empleadosTardios = array();
        $marcacionesArray = Marcacion::leerMarcaciones();
        foreach ($marcacionesArray as $marcacion){
            $empleado = $marcacion->empleado;
            $fechaMarcada = $marcacion->fechaHoraMarcacion;
            if($empleado instanceof Validable){
                if($empleado->validar($fechaMarcada)){  //quiere decir que llego tarde
                    $empleado->cantidadLlegadasTardias++;
                    if(!isset($empleadosTardios[$empleado->legajo])){
                        $empleadosTardios[$empleado->legajo] = $empleado;
                    }
                    $empleadosTardios[$empleado->legajo]->cantidadLlegadasTardias++;
                }
            }else{  //el unico que no es validable es el gerente

            }
        }
    }
}
