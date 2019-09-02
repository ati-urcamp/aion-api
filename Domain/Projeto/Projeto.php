<?php

namespace Domain\Projeto;

use Domain\Base\Models\BaseModel;
use Domain\Cliente\Cliente;
use Domain\ProjetoSituacao\ProjetoSituacao;
use Domain\ProjetoTipo\ProjetoTipo;
use Domain\Tarefa\Tarefa;

class Projeto extends BaseModel
{
    const CREATED_AT = 'dt_criacao';
    const UPDATED_AT = 'dt_modificacao';

    protected $connection = 'default';
    protected $table = 'projetos';

    protected $fillable = [
        'nome',
        'descricao',
        'ref_cliente',
        'ref_projeto_tipo',
        'ref_projeto_situacao',
        'ordem',
    ];

    protected $searchFillable = [
        'nome',
        'ref_cliente',
        'ref_projeto_tipo',
        'ref_projeto_situacao',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'ref_cliente');
    }

    public function tipo()
    {
        return $this->belongsTo(ProjetoTipo::class, 'ref_projeto_tipo');
    }

    public function situacao()
    {
        return $this->belongsTo(ProjetoSituacao::class, 'ref_projeto_situacao');
    }

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'ref_projeto');
    }
}
