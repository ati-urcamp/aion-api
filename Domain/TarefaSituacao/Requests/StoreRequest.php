<?php

namespace Domain\TarefaSituacao\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'nome' => 'required',
            'fl_visivel' => 'required',
        ];
    }
}
