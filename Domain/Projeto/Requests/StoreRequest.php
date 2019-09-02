<?php

namespace Domain\Projeto\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'nome' => 'required',
            'ref_cliente' => 'required',
            'ref_projeto_tipo' => 'required',
            'ref_projeto_situacao' => 'required',
            'ordem' => 'required',
        ];
    }
}
