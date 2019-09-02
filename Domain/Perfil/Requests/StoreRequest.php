<?php

namespace Domain\Perfil\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'nome' => 'required|unique:perfis,nome',
        ];
    }
}
