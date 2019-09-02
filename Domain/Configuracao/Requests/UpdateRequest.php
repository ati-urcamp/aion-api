<?php

namespace Domain\Configuracao\Requests;

class UpdateRequest extends StoreRequest
{
    public function rules()
    {
        $id = $this->route('configuracao');

        return array_merge(parent::rules(), [
            'nome' => 'required|unique:configuracoes,nome,' . $id . ',id',
        ]);
    }
}
