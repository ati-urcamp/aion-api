<?php

namespace Domain\ProjetoSituacao;

use Domain\Base\Models\BaseModel;
use Domain\Projeto\Projeto;

class ProjetoSituacao extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'projetos_situacoes';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'descricao',
        'ordem',
    ];

    protected $searchFillable = [
        'nome',
    ];

    public function projetos()
    {
        return $this->hasMany(Projeto::class, 'ref_projeto_situacao');
    }
}
