<?php

namespace Domain\Base\Examples\Units\Post\Requests;

use Domain\Base\Requests\Request;

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
    }
}
