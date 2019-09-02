<?php

use Illuminate\Database\Seeder;

class TarefasSituacoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $situacoes = [
            ['id' => 1, 'nome' => 'Criada', 'ordem' => 0, 'fl_visivel' => true, 'cor' => '#0288D1'],
            ['id' => 2, 'nome' => 'Fazer', 'ordem' => 1, 'fl_visivel' => true, 'cor' => '#E64A19'],
            ['id' => 3, 'nome' => 'Trabalhando', 'ordem' => 2, 'fl_visivel' => true, 'cor' => '#689F38'],
            ['id' => 4, 'nome' => 'Pausada', 'ordem' => 3, 'fl_visivel' => true, 'cor' => '#C2185B'],
            ['id' => 5, 'nome' => 'Finalizada', 'ordem' => 4, 'fl_visivel' => true, 'cor' => '#512DA8'],
            ['id' => 6, 'nome' => 'Testes/homologação', 'ordem' => 5, 'fl_visivel' => true, 'cor' => '#5D4037'],
            ['id' => 7, 'nome' => 'Impedido', 'ordem' => 6, 'fl_visivel' => true, 'cor' => '#D32F2F'],
            ['id' => 8, 'nome' => 'Arquivado', 'ordem' => 7, 'fl_visivel' => false, 'cor' => '#388E3C'],
        ];

        foreach ($situacoes as $situacao) {
            DB::table('tarefas_situacoes')->insert($situacao);
        }
    }
}
