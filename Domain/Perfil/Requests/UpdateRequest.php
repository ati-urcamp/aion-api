<?php

namespace Domain\Perfil\Requests;

class UpdateRequest extends StoreRequest
{
    public function rules()
    {
        $id = $this->route('perfil');

        return array_merge(parent::rules(), [
            'nome' => 'required|unique:perfis,nome,' . $id . ',id',
        ]);
    }
}
