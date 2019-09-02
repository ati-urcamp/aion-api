<?php

namespace Domain\TarefaChecklist\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'ref_tarefa' => 'required|exists:tarefas,id',
            'descricao' => 'required'
        ];
    }
}
