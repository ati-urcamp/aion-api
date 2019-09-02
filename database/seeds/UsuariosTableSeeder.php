<?php

use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipe = DB::table('equipes')->first();
        $perfil = DB::table('perfis')->first();

        $ref_usuario = DB::table('usuarios')->insertGetId([
            'nome' => 'Aion',
            'login' => 'aion',
            'senha' => bcrypt('102030'),
            'fl_ativo' => true,
            'ref_equipe' => $equipe->id,
            'dt_criacao' => now(),
            'dt_modificacao' => now(),
        ]);

        DB::table('usuarios_perfis')->insert([
            'ref_usuario' => $ref_usuario,
            'ref_perfil' => $perfil->id,
        ]);
    }
}
