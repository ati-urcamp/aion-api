<?php

namespace Domain\Cliente;

use Domain\Base\Models\BaseModel;
use Domain\Projeto\Projeto;

class Cliente extends BaseModel
{
    const CREATED_AT = 'dt_criacao';
    const UPDATED_AT = 'dt_modificacao';

    protected $connection = 'default';
    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'email',
        'responsavel',
    ];

    protected $searchFillable = [
        'nome',
        'responsavel',
    ];

    public function projetos()
    {
        return $this->hasMany(Projeto::class, 'ref_cliente');
    }
}
