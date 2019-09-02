<?php

namespace Domain\TarefaTipo\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'nome' => 'required',
            'esforco_padrao' => 'required',
        ];
    }
}
