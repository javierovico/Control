<?php

namespace App\ModelosBaseDato;

use Illuminate\Database\Eloquent\Model;

class Marcacion extends Model
{

    const HORARIO_ENTRADA = '08:00';
    const ARCHIVO = "C:/Marcaciones.txt";
    protected $fillable = ['empleado_id','fechaHoraMarcacion'];   //para poder agregarse
    public $timestamps = false;

    /**
     * Lee las marcaciones desde un archivo depositado en C:/Marcaciones.txt
     */
    public static function leerMarcaciones(){
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
            $empleadoBusqueda = Empleado::where('legajo' , '=' , $datosRecogido->legajo)->first();
            if($empleadoBusqueda == null ){     //si el empleado no existe todavia en la base de datos
                //se deberia ignorar o dar un error (implicaria que no existe el usuario)
                //pero en este caso, agregamos (ya que tenemos todos los datos necesarios)
                $empleadoBusqueda = new Empleado([
                    'legajo' => $datosRecogido->legajo,
                    'nombre' => $datosRecogido->nombre,
                    'apellido' => $datosRecogido->apellido,
                    //no podemos saber el valor de tiene tolerancia ni minutos de tolerancia
                ]);
                $empleadoBusqueda->save();
            }
            switch ($datosRecogido->tipo){
                case 'G':
                    $clasificacionEmpleado = Gerente::where('empleado_id', '=',$empleadoBusqueda->id)->first();
                    if($clasificacionEmpleado == null){
                        $clasificacionEmpleado = new Gerente([
                            'empleado_id' => $empleadoBusqueda->id, //el foreign key usado
                            //no podemos saber nada sobre su subresueldo ni su area
                        ]);
                        $clasificacionEmpleado->save();
                    }
                    break;
                case 'D':
                    $clasificacionEmpleado = Director::where('empleado_id', '=',$empleadoBusqueda->id)->first();
                    if($clasificacionEmpleado == null){
                        $clasificacionEmpleado = new Director([
                            'empleado_id' => $empleadoBusqueda->id, //el foreign key usado
                            //no podemos saber nada sobre su cantidad de llegadas tardias ni su departamento, ni tampoco sus subordinados
                        ]);
                        $empleadoBusqueda->tieneTolerancia = true;  //condicion dle problema
                        $empleadoBusqueda->minutosTolerancia = 5;  //condicion dle problema
                        $empleadoBusqueda->save();
                        $clasificacionEmpleado->save();
                    }
                    break;
                case 'S':
                    $clasificacionEmpleado = PersonalServicio::where('empleado_id', '=',$empleadoBusqueda->id)->first();
                    if($clasificacionEmpleado == null){
                        $clasificacionEmpleado = new PersonalServicio([
                            'empleado_id' => $empleadoBusqueda->id, //el foreign key usado
                            //no podemos saber nada sobre su cantidad de llegadas tardias ni su departamento, ni tampoco sus subordinados
                        ]);
                        $empleadoBusqueda->tieneTolerancia = false;  //condicion dle problema
                        $empleadoBusqueda->save();
                        $clasificacionEmpleado->save();
                    }
                    break;
                default:    //en caso de error
                    continue 2;   //recorre el proximo elemento en el array
                    break;
            }
            //llegado hasta aca tenemos el empleado y la clasificacionDelEmpleado (que por polimorfismo, al extender todas de la clase Models, tiene el mismo metodo save() que lo que hace es guardarle en la base de datos
            $fecha = date('Y-m-d H:i',\DateTime::createFromFormat('d/m/Y',$datosRecogido->fecha));
            if(strpos($fecha,'1970-')!==false){ //error en la fecha

            }else{
                $marcacionNueva = new Marcacion([
                    'fechaHoraMarcacion' => $fecha,
                    'empleado_id' => $empleadoBusqueda->id
                ]);
                $clasificacionEmpleado->save();
                $marcacionNueva->save();
            }
        }
    }
}
