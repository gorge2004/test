<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExceptionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exceptiones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('nota');
            $table->string('observacion')->nullable();
            $table->boolean('aprobado')->nullable();
            $table->boolean('laborable')->default(false);
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('gerente_id')->nullable();
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
        Schema::dropIfExists('exceptiones');
    }
}
