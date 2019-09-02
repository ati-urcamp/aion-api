<?php

namespace Domain\Permissao;

use Domain\Permissao\PermissaoRepository as Repository;
use Domain\Permissao\Requests\StoreRequest;
use Domain\Permissao\Requests\UpdateRequest;
use Illuminate\Http\Request;
use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\AllTrait;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetTrait;
use Domain\Base\Controllers\Traits\StoreTrait;
use Domain\Base\Controllers\Traits\UpdateTrait;

class PermissaoController extends AbstractController
{
    use AllTrait, GetTrait, StoreTrait, UpdateTrait, DeletesTrait;

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

    public function search(PermissaoService $service, Request $request)
    {
        return handleResponses($service->search($request->all(), $request->only('_limit', '_columns', '_with', '_page')));
    }
}
