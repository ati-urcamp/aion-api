<?php

namespace Domain\Perfil;

use Domain\Permissao\Permissao;
use Domain\Usuario\Usuario;
use Domain\Base\Models\BaseModel;

class Perfil extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'perfis';

    public $timestamps = false;

    protected $fillable = [
        'nome',
    ];

    protected $searchFillable = [
        'nome',
    ];

    public function permissoes()
    {
        return $this->belongsToMany(Permissao::class, 'perfis_permissoes', 'ref_perfil', 'ref_permissao');
    }

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuarios_perfis', 'ref_perfil', 'ref_usuario');
    }
}
