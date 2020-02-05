<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('empleado_id');  //foreign key
            $table->foreign('empleado_id')->references('id')->on('empleados');  //configuracion del foreign key
            $table->integer('cantidadLlegadasTardias')->default(0);
            $table->boolean('cobraInsalubridad')->default(false);
            $table->double('montoInsalubridad')->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_servicios');
    }
}
