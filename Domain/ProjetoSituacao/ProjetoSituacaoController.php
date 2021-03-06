<?php

namespace Domain\ProjetoSituacao;

use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;
use Domain\Base\Controllers\Traits\StoreTrait;
use Domain\Base\Controllers\Traits\UpdateTrait;
use Domain\ProjetoSituacao\ProjetoSituacaoRepository as Repository;
use Domain\ProjetoSituacao\Requests\StoreRequest;
use Domain\ProjetoSituacao\Requests\UpdateRequest;

class ProjetoSituacaoController extends AbstractController
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
