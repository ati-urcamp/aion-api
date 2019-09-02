<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetosTiposForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->unsignedInteger('ref_projeto_tipo');
            $table->foreign('ref_projeto_tipo')->references('id')->on('projetos_tipos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->dropForeign(['ref_projeto_tipo']);
            $table->dropColumn('ref_projeto_tipo');
        });
    }
}
