<?php

namespace Domain\TarefaChecklist;

use Domain\Base\Models\BaseModel;
use Domain\Tarefa\Tarefa;

class TarefaChecklist extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'tarefas_checklist';

    public $timestamps = false;

    protected $fillable = [
        'ref_tarefa',
        'descricao',
        'finalizada',
    ];

    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class, 'ref_tarefa');
    }
}
