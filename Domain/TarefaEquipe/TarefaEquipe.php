<?php

namespace Domain\TarefaEquipe;

use Domain\Base\Models\BaseModel;
use Domain\Equipe\Equipe;
use Domain\Tarefa\Tarefa;

class TarefaEquipe extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'tarefas_equipes';

    public $timestamps = false;

    protected $fillable = [
        'ref_tarefa',
        'ref_equipe',
    ];

    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class, 'ref_tarefa');
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'ref_equipe');
    }
}
