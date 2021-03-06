<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->integer('legajo')->primary();    //seria como el id ?
            $table->string('nombre',200);
            $table->string('apellido',200);
            $table->integer('tipo_empleado_id')->nullable();
            $table->foreign('tipo_empleado_id')->references('id')->on('tipo_empleados');
            $table->boolean('tiene_tolerancia')->default(false); //Aparentemente es un campo calculado (true si minutosTolerancia >0)
            $table->integer('minutos_tolerancia')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
