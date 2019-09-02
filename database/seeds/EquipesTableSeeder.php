<?php

use Illuminate\Database\Seeder;

class EquipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equipes')->insert([
            'nome' => 'Foo',
            'encarregado' => 'John Doe',
            'dt_criacao' => now(),
            'dt_modificacao' => now(),
            'arvore' => json_encode([['id' => 1, 'nome' => 'Foo']]),
            'arvore_humanizada' => 'Foo',
        ]);
    }
}
