<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscripcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->id();
            $table->integer('nro_entrada')->nullable();
            $table->date('fecha');
            $table->string('n_apellido');
            $table->bigInteger('celular')->nullable();
            $table->string('membresia');
            $table->string('valorTotal');
            $table->string('inscribio');
            $table->string('promo');
            //$table->boolean('completado')->nullable()->change(); //para tomar los cambios
            $table->boolean('completado')->nullable();
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
        Schema::dropIfExists('inscripcions');
    }
}
