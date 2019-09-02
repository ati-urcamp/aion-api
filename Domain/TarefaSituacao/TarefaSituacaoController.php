<?php

namespace Domain\TarefaSituacao;

use Domain\TarefaSituacao\Requests\StoreRequest;
use Domain\TarefaSituacao\Requests\UpdateRequest;
use Domain\TarefaSituacao\TarefaSituacaoRepository as Repository;
use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;
use Domain\Base\Controllers\Traits\StoreTrait;
use Domain\Base\Controllers\Traits\UpdateTrait;

class TarefaSituacaoController extends AbstractController
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

    public function totaisPorSituacao(TarefaSituacaoService $service)
    {
        return handleResponses($service->buscarTotaisPorSituacao());
    }
}
