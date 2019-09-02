<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarefasChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefas_checklist', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ref_tarefa');
            $table->text('descricao');
            $table->boolean('finalizada')->default(false);

            $table->foreign('ref_tarefa')->references('id')->on('tarefas');
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
        Schema::dropIfExists('tarefas_checklist');
    }
}
