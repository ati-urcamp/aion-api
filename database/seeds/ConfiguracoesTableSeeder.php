<?php

use Illuminate\Database\Seeder;

class ConfiguracoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configuracoes = [
            ['nome' => 'TAREFA_SITUACAO_INICIAR', 'valor' => 3],
            ['nome' => 'TAREFA_SITUACAO_PAUSAR', 'valor' => 4],
            ['nome' => 'TAREFA_SITUACAO_FINALIZAR', 'valor' => 5],
            ['nome' => 'TAREFA_SITUACAO_REABRIR', 'valor' => 1],
            ['nome' => 'TAREFA_SITUACAO_ARQUIVAR', 'valor' => 8],
        ];

        foreach ($configuracoes as $configuracao) {
            DB::table('configuracoes')->insert($configuracao);
        }
    }
}
