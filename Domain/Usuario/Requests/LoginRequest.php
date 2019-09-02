<?php

namespace Domain\Usuario\Requests;

use Domain\Base\Requests\Request;

class LoginRequest extends Request
{
    public function rules()
    {
        return [
            'login' => 'required',
            'password' => 'required',
        ];
    }
}
