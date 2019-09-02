<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_horarios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ref_usuario');
            $table->unsignedInteger('dia_semana');
            $table->time('hora_entrada');
            $table->time('hora_saida');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios_horarios');
    }
}
