<?php

namespace Domain\Perfil;

use Domain\Perfil\PerfilRepository as Repository;
use Domain\Perfil\Requests\StoreRequest;
use Domain\Perfil\Requests\UpdateRequest;
use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;

class PerfilController extends AbstractController
{
    use GetsTrait, DeletesTrait;

    public function repo()
    {
        return Repository::class;
    }

    /**
     * @param PerfilService $service
     * @param StoreRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(PerfilService $service, StoreRequest $request)
    {
        return handleResponses($service->store($request->all()));
    }

    /**
     * @param PerfilService $service
     * @param int $ref_perfil
     * @param UpdateRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(PerfilService $service, int $ref_perfil, UpdateRequest $request)
    {
        return handleResponses($service->update($request->all(), $ref_perfil));
    }
}
