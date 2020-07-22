<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectoTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_temps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('empresa_id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('nombre');
            $table->text('direccion');
            $table->text('descripcion');
            $table->float('gastos_generales');
            $table->float('utilidad');
            $table->float('descuento')->default(0);
            $table->float('gasto_estimado');
            $table->integer('estatus')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto_temps');
    }
}
