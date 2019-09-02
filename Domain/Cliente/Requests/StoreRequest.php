<?php

namespace Domain\Cliente\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'nome' => 'required',
            'responsavel' => 'required',
        ];
    }
}
