<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropGrupoIdColumnToGuardiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guardias', function (Blueprint $table) {
            $table->dropColumn('grupo_id');
            $table->dropColumn('grupo_temporada_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guardias', function (Blueprint $table) {
            $table->unsignedBigInteger('grupo_id')->nullable();
            $table->unsignedBigInteger('grupo_temporada_id')->nullable();
        });
    }
}
