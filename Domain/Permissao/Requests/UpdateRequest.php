<?php

namespace Domain\Permissao\Requests;

class UpdateRequest extends StoreRequest
{
    public function rules()
    {
        $id = $this->route('permissao');

        return array_merge(parent::rules(), [
            'nome' => 'required|unique:permissoes,nome,' . $id . ',id',
        ]);
    }
}
