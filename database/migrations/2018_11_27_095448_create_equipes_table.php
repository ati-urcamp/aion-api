<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 255);
            $table->text('descricao')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('encarregado', 255);
            $table->unsignedInteger('ref_equipe')->nullable();
            $table->timestamp('dt_criacao');
            $table->timestamp('dt_modificacao');
            $table->text('arvore')->nullable();
            $table->text('arvore_humanizada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipes');
    }
}
