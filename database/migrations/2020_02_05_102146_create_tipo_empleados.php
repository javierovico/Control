<?php

use App\Empleado;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoEmpleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_empleados', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('nominacion',200);   // 'gerente', 'personal_servicio','director' hasta ahora
        });
        $nominaciones = [
            Empleado::TIPO_GERENTE              =>        'gerente',
            Empleado::TIPO_PERSONAL_SERVICIO    =>        'personal_servicio',
            Empleado::TIPO_DIRECTOR             =>        'director'
        ];
        foreach ($nominaciones as $key=>$nominacion){
            DB::table('tipo_empleados')->insert([
                'id' => $key,
                'nominacion' => $nominacion
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_empleados');
    }
}
