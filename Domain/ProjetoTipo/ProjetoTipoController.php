<?php

namespace Domain\ProjetoTipo;

use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;
use Domain\Base\Controllers\Traits\StoreTrait;
use Domain\Base\Controllers\Traits\UpdateTrait;
use Domain\ProjetoTipo\ProjetoTipoRepository as Repository;
use Domain\ProjetoTipo\Requests\StoreRequest;
use Domain\ProjetoTipo\Requests\UpdateRequest;

class ProjetoTipoController extends AbstractController
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
