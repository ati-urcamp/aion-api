<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 255);
            $table->string('email', 255)->nullable();
            $table->string('login', 255);
            $table->string('senha', 255);
            $table->text('avatar')->nullable();
            $table->boolean('fl_ativo')->default(false);
            $table->unsignedInteger('ref_equipe');
            $table->timestamp('dt_criacao');
            $table->timestamp('dt_modificacao');
            $table->decimal('valor_hora', 15, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
