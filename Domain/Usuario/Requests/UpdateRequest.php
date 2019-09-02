<?php

namespace Domain\Usuario\Requests;

class UpdateRequest extends StoreRequest
{
    public function rules()
    {
        $id = $this->route('usuario');

        return array_merge(parent::rules(), [
            'login' => 'required|alpha_dash|max:15|unique:usuarios,login,' . $id,
            'senha' => 'nullable|min:6|required_with:senha_confirmation|confirmed',
        ]);
    }
}
