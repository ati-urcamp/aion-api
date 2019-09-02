<?php

namespace Domain\Configuracao;

use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;
use Domain\Base\Controllers\Traits\StoreTrait;
use Domain\Base\Controllers\Traits\UpdateTrait;
use Domain\Configuracao\ConfiguracaoRepository as Repository;
use Domain\Configuracao\Requests\StoreRequest;
use Domain\Configuracao\Requests\UpdateRequest;

class ConfiguracaoController extends AbstractController
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
