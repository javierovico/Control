<?php

namespace App\Http\Controllers;

use App\ModelosBaseDato\Registro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $request->validate([
            'legajo'        => 'integer',
            'fechaInicio'   => 'date_format:Y-m-d',
            'fechaFin'      => 'date_format:Y-m-d',
            'todosLosRegistros' => 'integer'    //por si se quieran generar todos los registros de una
        ]);
        $legajo = $request->legajo;
        $fechaInicio = $request->fechaInicio;
        $fechaFin = $request->fechaFin;
        if($fechaInicio == null || $fechaFin == null){  //si no se recibe uno de los dos, ya se asume que hay que traer del dia actual
            $fechaInicio = Carbon::now()->format('Y-m-d');
            $fechaFin = Carbon::now()->format('Y-m-d');
        }
        try{
            if($request->todosLosRegistros){
                $registros = Registro::all();
            }else{
                $registros = Registro::whereBetween('fecha',[$fechaInicio,$fechaFin]);
                if($legajo!=null){      //si es filtrado por usuario
                    $registros = $registros->where('legajo','=',$legajo);
                }
                $registros = $registros->get();
            }
            return [
                'success'=>true,
                'mensaje'=>"Registros dentro del rango $fechaInicio y $fechaFin" . (($legajo)?" del legajo $legajo":""),
                'cantidadRegistroEncontrado' =>count($registros),
                'registros'=>$registros
            ];
        }catch (\Exception $e){
            return [
                'success'   => false,
                'mensaje' => $e->getMessage()
            ];
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function libre(Request $request)
    {
        $request->validate([
            'legajo'        => 'integer',
            'fechaInicio'   => 'date_format:Y-m-d',
            'fechaFin'      => 'date_format:Y-m-d'
        ]);
        $legajo = $request->legajo;
        $fechaInicio = $request->fechaInicio;
        $fechaFin = $request->fechaFin;
        $registros = Registro::where('legajo','>','0');
        if($fechaInicio != null && $fechaFin != null){
            $registros->whereBetween('fecha',[$fechaInicio,$fechaFin]);
        }
        if($legajo){
            $registros->where('legajo','=',$legajo);
        }
        $registros = $registros->get();
        return [
            'success'=>true,
            'mensaje'=>"Registros dentro del rango $fechaInicio y $fechaFin" . (($legajo)?" del legajo $legajo":""),
            'cantidadRegistroEncontrado' =>count($registros),
            'registros'=>$registros
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
