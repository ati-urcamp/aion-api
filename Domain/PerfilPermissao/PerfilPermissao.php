<?php

namespace Domain\PerfilPermissao;

use Domain\Perfil\Perfil;
use Domain\Permissao\Permissao;
use Domain\Base\Models\BaseModel;

class PerfilPermissao extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'perfis_permissoes';

    public $timestamps = false;

    protected $fillable = [
        'ref_perfil',
        'ref_permissao',
    ];

    protected $searchFillable = [];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'ref_perfil');
    }

    public function permissao()
    {
        return $this->belongsTo(Permissao::class, 'ref_permissao');
    }
}
