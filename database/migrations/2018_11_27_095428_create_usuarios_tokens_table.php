<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ref_usuario');
            $table->text('token');
            $table->boolean('fl_ativo')->default(false);
            $table->timestamp('dt_criacao');
            $table->timestamp('dt_modificacao');

            $table->foreign('ref_usuario')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('usuarios_tokens', function (Blueprint $table) {
            $table->dropForeign(['ref_usuario']);
        });

        Schema::dropIfExists('usuarios_tokens');
    }
}
