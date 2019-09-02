<?php

namespace Domain\Usuario;

use Domain\Usuario\Requests\LoginRequest;
use Domain\Usuario\Requests\StoreRequest;
use Domain\Usuario\Requests\UpdateRequest;
use Domain\Usuario\UsuarioRepository as Repository;
use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;

class UsuarioController extends AbstractController
{
    use GetsTrait, DeletesTrait;

    public function repo()
    {
        return Repository::class;
    }

    /**
     * @param UsuarioService $service
     * @param LoginRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function login(UsuarioService $service, LoginRequest $request)
    {
        return handleResponses($service->login($request->only(['login', 'password'])));
    }

    /**
     * @param UsuarioService $service
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function logout(UsuarioService $service)
    {
        return handleResponses($service->logout());
    }

    /**
     * @param UsuarioService $service
     * @param StoreRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(UsuarioService $service, StoreRequest $request)
    {
        return handleResponses($service->store($request->all()));
    }

    /**
     * @param UsuarioService $service
     * @param int $ref_usuario
     * @param UpdateRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UsuarioService $service, int $ref_usuario, UpdateRequest $request)
    {
        return handleResponses($service->update($request->all(), $ref_usuario));
    }
}
