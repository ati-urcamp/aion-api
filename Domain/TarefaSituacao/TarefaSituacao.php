<?php

namespace Domain\TarefaSituacao;

use Domain\Base\Models\BaseModel;
use Domain\Tarefa\Tarefa;

class TarefaSituacao extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'tarefas_situacoes';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'descricao',
        'ordem',
        'fl_visivel',
        'cor',
    ];

    protected $searchFillable = [
        'nome',
    ];

    protected $casts = [
        'fl_visivel' => 'boolean',
    ];

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'ref_tarefa_situacao');
    }
}
