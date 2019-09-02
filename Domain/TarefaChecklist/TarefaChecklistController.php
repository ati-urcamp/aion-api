<?php

namespace Domain\TarefaChecklist;

use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;
use Domain\Base\Controllers\Traits\StoreTrait;
use Domain\Base\Controllers\Traits\UpdateTrait;
use Domain\TarefaChecklist\TarefaChecklistRepository as Repository;
use Domain\TarefaChecklist\Requests\StoreRequest;
use Domain\TarefaChecklist\Requests\UpdateRequest;

class TarefaChecklistController extends AbstractController
{
    use GetsTrait, StoreTrait, UpdateTrait, DeletesTrait;

    public function repo()
    {
        return Repository::class;
    }

    public function storeRequest()
    {
        return StoreRequest::class;
    }

    public function updateRequest()
    {
        return UpdateRequest::class;
    }
}
