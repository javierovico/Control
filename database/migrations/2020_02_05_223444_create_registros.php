<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->integer('legajo');
            $table->foreign('legajo')->references('legajo')->on('empleados');   //foreign key
            $table->date('fecha');      //solo contiene la fecha
            $table->string('hora',5);   // en el formato: '08:59'
            $table->boolean('tardio');
            $table->integer('minutos_tarde');
            $table->primary(['legajo','fecha']);    //para que no se guarden archivos repetidos (no puede ser que un mismo empleado marque en la misma fecha dos veces o mas)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros');
    }
}
