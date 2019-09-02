<?php

namespace Domain\Equipe;

use Domain\Equipe\EquipeRepository as Repository;
use Domain\Equipe\Requests\StoreRequest;
use Domain\Equipe\Requests\UpdateRequest;
use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;

class EquipeController extends AbstractController
{
    use GetsTrait, DeletesTrait;

    public function repo()
    {
        return Repository::class;
    }

    /**
     * @param EquipeService $service
     * @param StoreRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(EquipeService $service, StoreRequest $request)
    {
        return handleResponses($service->store($request->all()));
    }

    /**
     * @param EquipeService $service
     * @param int $ref_equipe
     * @param UpdateRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(EquipeService $service, int $ref_equipe, UpdateRequest $request)
    {
        return handleResponses($service->update($request->all(), $ref_equipe));
    }
}
