<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissoesTableSeeder::class);
        $this->call(PerfisTableSeeder::class);
        $this->call(EquipesTableSeeder::class);
        $this->call(UsuariosTableSeeder::class);
        $this->call(ProjetosSituacoesTableSeeder::class);
        $this->call(ProjetosTiposTableSeeder::class);
        $this->call(TarefasSituacoesTableSeeder::class);
        $this->call(TarefasTiposTableSeeder::class);
        $this->call(ConfiguracoesTableSeeder::class);
    }
}
