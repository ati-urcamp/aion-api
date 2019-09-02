<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarefasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 255);
            $table->text('descricao')->nullable();
            $table->text('tags')->nullable();
            $table->unsignedInteger('ref_tarefa_tipo');
            $table->unsignedInteger('ref_tarefa_situacao');
            $table->unsignedInteger('ref_projeto');
            $table->unsignedInteger('esforco_estimado')->default(0);
            $table->date('dt_desejada');
            $table->timestamp('dt_criacao');
            $table->timestamp('dt_modificacao');
            $table->unsignedInteger('ordem')->default(0);
            $table->boolean('fl_iniciada')->default(false);
            $table->boolean('fl_pausada')->default(false);
            $table->boolean('fl_finalizada')->default(false);
            $table->unsignedInteger('ref_usuario_timesheet')->nullable();
            $table->unsignedInteger('ref_usuario_finalizado')->nullable();
            $table->unsignedInteger('ref_usuario_reaberto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarefas');
    }
}
