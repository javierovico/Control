<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcacions', function (Blueprint $table) {
            $table->timestamp('fechaHoraMarcacion');        //notese que por defecto, todos las columnas son not nulls (a no ser que sea explicitamente declarado nullable())
            $table->unsignedBigInteger('empleado_id');      //por convencion, las claves foraneas en laravel deben definirse de esta forma: el nombre de la tabla (en singular) mas _id
            $table->foreign('empleado_id')->references('id')->on('empleado');   //foreign key
            $table->primary(['fechaHoraMarcacion','empleado_id']);  //para evitar que se alzen archivos repetidos (un mismo empleado no puedo marcar en el mismo segundo dos veces)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcacions');
    }
}
