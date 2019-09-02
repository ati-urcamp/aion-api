<?php

use Illuminate\Database\Seeder;

class ProjetosSituacoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $situacoes = [
            ['nome' => 'Solicitado', 'ordem' => 1],
            ['nome' => 'Fazer', 'ordem' => 2],
            ['nome' => 'Fazendo', 'ordem' => 3],
            ['nome' => 'Impedido', 'ordem' => 0],
            ['nome' => 'Arquivado', 'ordem' => 10],
            ['nome' => 'Finalizado', 'ordem' => 5],
            ['nome' => 'Homologação', 'ordem' => 4],
        ];

        foreach ($situacoes as $situacao) {
            DB::table('projetos_situacoes')->insert($situacao);
        }
    }
}
