<?php

use Illuminate\Database\Seeder;

class TarefasTiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            ['nome' => 'Ajudando alguém', 'cor' => '#F57C00'],
            ['nome' => 'Fazendo alguma coisa', 'cor' => '#689F38'],
            ['nome' => 'Corrigindo algum problema', 'cor' => '#D32F2F'],
        ];

        foreach ($tipos as $tipo) {
            DB::table('tarefas_tipos')->insert($tipo);
        }
    }
}
