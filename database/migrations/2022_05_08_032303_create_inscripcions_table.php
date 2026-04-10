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
            $table->integer('nro_entrada')->nullable(); //quizá no se use, pero se lo deja.
            $table->date('fecha');
            $table->string('n_apellido');
            $table->bigInteger('celular')->nullable();
            $table->string('membresia'); // (local, interior, otra_iglesia)
            $table->string('valorTotal'); // valor que deberá pagar en total
            $table->string('inscribio'); // id de la persona que inscribe ('nn': no se sabe)
            $table->string('tipo'); // (general, adolescente, pastora, especial)
            $table->string('financiacion'); // (completo; cuotas)
            $table->boolean('completado')->nullable(); //cuando se completa el pago
            $table->string('observacion')->nullable();
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
