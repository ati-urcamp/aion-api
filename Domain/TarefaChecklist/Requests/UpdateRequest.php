<?php

namespace Domain\TarefaChecklist\Requests;

class UpdateRequest extends StoreRequest
{
    public function rules()
    {
        return [
            'ref_tarefa' => 'required|exists:tarefas,id'
        ];
    }
}
