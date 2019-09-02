<?php

namespace Domain\TarefaTipo;

use Domain\TarefaTipo\Requests\StoreRequest;
use Domain\TarefaTipo\Requests\UpdateRequest;
use Domain\TarefaTipo\TarefaTipoRepository as Repository;
use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;
use Domain\Base\Controllers\Traits\StoreTrait;
use Domain\Base\Controllers\Traits\UpdateTrait;

class TarefaTipoController extends AbstractController
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

    public function totaisPorTipo(TarefaTipoService $service)
    {
        return handleResponses($service->buscarTotaisPorTipo());
    }
}
