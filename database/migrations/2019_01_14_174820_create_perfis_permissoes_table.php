<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfisPermissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfis_permissoes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ref_perfil');
            $table->unsignedInteger('ref_permissao');

            $table->unique(['ref_perfil', 'ref_permissao']);

            $table->foreign('ref_perfil')->references('id')->on('perfis');
            $table->foreign('ref_permissao')->references('id')->on('permissoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('perfis_permissoes', function (Blueprint $table) {
            $table->dropForeign(['ref_perfil']);
            $table->dropForeign(['ref_permissao']);
        });

        Schema::dropIfExists('perfis_permissoes');
    }
}
