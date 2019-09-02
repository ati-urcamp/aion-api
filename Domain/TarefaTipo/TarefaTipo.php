<?php

namespace Domain\TarefaTipo;

use Domain\Base\Models\BaseModel;
use Domain\Tarefa\Tarefa;

class TarefaTipo extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'tarefas_tipos';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'descricao',
        'esforco_padrao',
        'cor',
    ];

    protected $searchFillable = [
        'nome',
    ];

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'ref_tarefa_tipo');
    }
}
