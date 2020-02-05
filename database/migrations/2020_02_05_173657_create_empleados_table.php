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
            $table->bigIncrements('id');
            $table->integer('legajo')->unique();    //seria como el id ?
            $table->string('nombre',200);
            $table->string('apellido',200);
            $table->boolean('tieneTolerancia')->default(false); //Aparentemente es un campo calculado (true si minutosTolerancia >0)
            $table->integer('minutosTolerancia')->default(0);
            //podria asignarle un usuario a cada empleado, pero vamos a separar esto, ya que no tenemos datos suficientes para la creacion de usuarios (contrasenhas)
            //por lo que la tabla de "users" solo se destinara para la autenticacion en la plataforma
//            $table->unsignedBigInteger('user_id');
//            $table->foreign('user_id')->references('id')->on('users');
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
