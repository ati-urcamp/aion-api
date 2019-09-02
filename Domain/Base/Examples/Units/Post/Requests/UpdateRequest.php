<?php

namespace Domain\Base\Examples\Units\Post\Requests;

class UpdateRequest extends StoreRequest
{
    public function rules()
    {
        $id = $this->route('post');
        return array_merge(
            parent::rules(),
            [
                'title' => 'required|unique:posts,title,' . $id . ',id'
            ]
        );
    }
}
