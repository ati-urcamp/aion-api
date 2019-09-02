<?php

namespace Domain\ProjetoTipo;

use Domain\Base\Models\BaseModel;
use Domain\Projeto\Projeto;

class ProjetoTipo extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'projetos_tipos';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'descricao',
    ];

    protected $searchFillable = [
        'nome',
    ];

    public function projetos()
    {
        return $this->hasMany(Projeto::class, 'ref_projeto_tipo');
    }
}
