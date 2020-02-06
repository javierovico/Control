<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametroEmpleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametro_empleados', function (Blueprint $table) {
            $table->integer('legajo_id');
            $table->foreign('legajo_id')->references('legajo')->on('empleados');
            $table->string('parametro',200);    //el parametro
            $table->string('valor',200)->nullable();    //el valor del parametro
            $table->primary(['legajo_id','parametro']); //para que un mismo empleado no pueda tener atributos repetidos (para que la base siempre este en un estado valido
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametro_empleados');
    }
}
