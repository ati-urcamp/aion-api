<?php

namespace Domain\Permissao;

use Domain\Perfil\Perfil;
use Domain\Base\Models\BaseModel;

class Permissao extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'permissoes';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'nome_legivel',
    ];

    protected $searchFillable = [
        'nome',
        'nome_legivel',
    ];

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'perfis_permissoes', 'ref_permissao', 'ref_perfil');
    }
}
