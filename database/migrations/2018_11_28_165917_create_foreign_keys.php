<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign('ref_equipe')->references('id')->on('equipes');
        });

        Schema::table('usuarios_horarios', function (Blueprint $table) {
            $table->foreign('ref_usuario')->references('id')->on('usuarios');
        });

        Schema::table('equipes', function (Blueprint $table) {
            $table->foreign('ref_equipe')->references('id')->on('equipes');
        });

        Schema::table('tarefas', function (Blueprint $table) {
            $table->foreign('ref_tarefa_tipo')->references('id')->on('tarefas_tipos');
            $table->foreign('ref_tarefa_situacao')->references('id')->on('tarefas_situacoes');
            $table->foreign('ref_projeto')->references('id')->on('projetos');
            $table->foreign('ref_usuario_timesheet')->references('id')->on('usuarios');
            $table->foreign('ref_usuario_finalizado')->references('id')->on('usuarios');
            $table->foreign('ref_usuario_reaberto')->references('id')->on('usuarios');
        });

        Schema::table('tarefas_equipes', function (Blueprint $table) {
            $table->foreign('ref_tarefa')->references('id')->on('tarefas');
            $table->foreign('ref_equipe')->references('id')->on('equipes');
        });

        Schema::table('tarefas_usuarios', function (Blueprint $table) {
            $table->foreign('ref_tarefa')->references('id')->on('tarefas');
            $table->foreign('ref_usuario')->references('id')->on('usuarios');
        });

        Schema::table('projetos', function (Blueprint $table) {
            $table->foreign('ref_cliente')->references('id')->on('clientes');
            $table->foreign('ref_projeto_situacao')->references('id')->on('projetos_situacoes');
        });

        Schema::table('timesheets', function (Blueprint $table) {
            $table->foreign('ref_tarefa')->references('id')->on('tarefas');
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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign(['ref_equipe']);
        });

        Schema::table('usuarios_horarios', function (Blueprint $table) {
            $table->dropForeign(['ref_usuario']);
        });

        Schema::table('equipes', function (Blueprint $table) {
            $table->dropForeign(['ref_equipe']);
        });

        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropForeign(['ref_tarefa_tipo']);
            $table->dropForeign(['ref_tarefa_situacao']);
            $table->dropForeign(['ref_projeto']);
            $table->dropForeign([
                'ref_usuario_timesheet',
                'ref_usuario_finalizado',
                'ref_usuario_reaberto',
            ]);
        });

        Schema::table('tarefas_equipes', function (Blueprint $table) {
            $table->dropForeign(['ref_tarefa']);
            $table->dropForeign(['ref_equipe']);
        });

        Schema::table('tarefas_usuarios', function (Blueprint $table) {
            $table->dropForeign(['ref_tarefa']);
            $table->dropForeign(['ref_usuario']);
        });

        Schema::table('projetos', function (Blueprint $table) {
            $table->dropForeign(['ref_cliente']);
            $table->dropForeign(['ref_projeto_situacao']);
        });

        Schema::table('timesheets', function (Blueprint $table) {
            $table->dropForeign(['ref_tarefa']);
            $table->dropForeign(['ref_usuario']);
        });
    }
}
