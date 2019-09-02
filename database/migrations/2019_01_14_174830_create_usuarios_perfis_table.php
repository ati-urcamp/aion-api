<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosPerfisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_perfis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ref_usuario');
            $table->unsignedInteger('ref_perfil');

            $table->unique(['ref_usuario', 'ref_perfil']);

            $table->foreign('ref_usuario')->references('id')->on('usuarios');
            $table->foreign('ref_perfil')->references('id')->on('perfis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('usuarios_perfis', function (Blueprint $table) {
            $table->dropForeign(['ref_usuario']);
            $table->dropForeign(['ref_perfil']);
        });

        Schema::dropIfExists('usuarios_perfis');
    }
}
