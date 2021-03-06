<?php

namespace App\Http\Controllers;

use App\Marcacion;
use App\Validable;
use Illuminate\Http\Request;

class ControladorPrincipal extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function __invoke(Request $request)
    {
        $marcaciones = app('App\Http\Controllers\RegistroController')->index($request);
        $empleados = app('App\Http\Controllers\EmpleadoController')->index($request);
        $tipoEmpleado = app('App\Http\Controllers\EmpleadoController')->tipoEmpleado($request);
        return [
            'marcaciones'   => $marcaciones,
            'empleados'     => $empleados,
            'tipo_empleado' => $tipoEmpleado,
        ];
    }

    public function libre(Request $request){
        $marcaciones = app('App\Http\Controllers\RegistroController')->libre($request);
        $empleados = app('App\Http\Controllers\EmpleadoController')->index($request);
        $tipoEmpleado = app('App\Http\Controllers\EmpleadoController')->tipoEmpleado($request);
        return [
            'marcaciones'   => $marcaciones,
            'empleados'     => $empleados,
            'tipo_empleado' => $tipoEmpleado,
        ];
    }

    public function recorrer(){
        $empleadosTardios = array();
        $marcacionesArray = Marcacion::leerMarcaciones();       //optiene en un array todas las marcaciones del dia
        foreach ($marcacionesArray as $marcacion){              //recorre el array para validar las llegadas tardias
            $empleado = $marcacion->empleado;                   //optiene el empleado de la marcacion
            $fechaMarcada = $marcacion->fechaMarcacion;         //optiene la fecha de marcacion
            $horaMarcada = $marcacion->horaMarcacion;
            if($empleado instanceof Validable){                 //pregunta si el empleado puede ser validado (los unicos que pueden ser validados son los Directores y PersonalServicio
                if($empleado->validar($horaMarcada)){           //Pregunta si llego tarde
                    if(!isset($empleadosTardios[$empleado->legajo])){           //pregunta si el empleado ya se cargo en el Map
                        $empleadosTardios[$empleado->legajo] = $empleado;       //sino, lo agrega
                    }
                    $empleadosTardios[$empleado->legajo]->cantidadLlegadasTardias++;    //aumenta sus llegadas tardias
                }
            }else{  //el unico que no es validable es el gerente

            }
            try{        //realizamos toda la accion en un try para manejar los errores (en este caso pueden producirse errores al insertar duplicados (restringido por base de dato))
                /** Primero guardamos los datos del empleado (si fuese necesario) **/
                $empleado->guardarseSiNoExiste();
                /** Ahora independientemente si el empleado llego tarde o no, se guarda en el registro de la base de datos **/
                $marcacion->guardarseSiNoExiste();
            }catch (\Exception $exception){
                return response()->json(['success'=>false,'error' => $exception->getMessage()],403);
            }
        }
        return response()->json(['success' => true, 'mensaje'=>'se crearon los registros','informeArchivo'=>$empleadosTardios]);
    }
}
