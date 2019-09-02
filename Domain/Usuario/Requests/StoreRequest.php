<?php

namespace Domain\Usuario\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'nome' => 'required',
            'login' => 'required|alpha_dash|max:15|unique:usuarios',
            'senha' => 'required|min:6|confirmed',
            'fl_ativo' => 'required',
            'ref_equipe' => 'required',
        ];
    }
}
