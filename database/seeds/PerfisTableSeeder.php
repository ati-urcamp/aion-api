<?php

use Illuminate\Database\Seeder;

class PerfisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ref_perfil = DB::table('perfis')->insertGetId([
            'nome' => 'Acesso total',
        ]);

        $permissoes = DB::table('permissoes')->get();

        foreach ($permissoes as $permissao) {
            DB::table('perfis_permissoes')->insert([
                'ref_perfil' => $ref_perfil,
                'ref_permissao' => $permissao->id,
            ]);
        }
    }
}
