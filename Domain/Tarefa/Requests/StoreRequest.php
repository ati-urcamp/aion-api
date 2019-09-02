<?php

namespace Domain\Tarefa\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'titulo' => 'required',
            'ref_tarefa_tipo' => 'required',
            'ref_tarefa_situacao' => 'required',
            'ref_projeto' => 'required',
            'esforco_estimado' => 'required',
            'dt_desejada' => 'required',
            'equipes' => 'required_without:usuarios',
            'usuarios' => 'required_without:equipes',
        ];
    }
}
