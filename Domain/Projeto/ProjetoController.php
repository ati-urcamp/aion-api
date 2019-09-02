<?php

namespace Domain\Projeto;

use Domain\Projeto\ProjetoRepository as Repository;
use Domain\Projeto\Requests\StoreRequest;
use Domain\Projeto\Requests\UpdateRequest;
use Illuminate\Http\Request;
use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;
use Domain\Base\Controllers\Traits\StoreTrait;
use Domain\Base\Controllers\Traits\UpdateTrait;

class ProjetoController extends AbstractController
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

    /**
     * @param ProjetoService $service
     * @param int $ref_projeto
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function atualizarSituacao(ProjetoService $service, int $ref_projeto, Request $request)
    {
        return handleResponses($service->atualizarSituacao($ref_projeto, $request->all()));
    }

    /**
     * @param ProjetoService $service
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function reordenar(ProjetoService $service, Request $request)
    {
        return handleResponses($service->reordenar($request->all()));
    }
}
