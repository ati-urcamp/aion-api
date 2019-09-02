<?php

namespace Domain\Permissao\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'nome' => 'required|unique:permissoes,nome',
        ];
    }
}
