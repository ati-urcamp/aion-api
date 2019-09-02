<?php

namespace Domain\Configuracao\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'nome' => 'required|unique:configuracoes,nome',
        ];
    }
}
