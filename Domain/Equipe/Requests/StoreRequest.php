<?php

namespace Domain\Equipe\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'nome' => 'required',
            'encarregado' => 'required',
        ];
    }
}
