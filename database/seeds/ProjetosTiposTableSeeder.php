<?php

use Illuminate\Database\Seeder;

class ProjetosTiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            ['nome' => 'Demandas Técnicas'],
            ['nome' => 'Desenvolvimento Contínuo'],
            ['nome' => 'Criação/Modificação de processo existente'],
        ];

        foreach ($tipos as $tipo) {
            DB::table('projetos_tipos')->insert($tipo);
        }
    }
}
