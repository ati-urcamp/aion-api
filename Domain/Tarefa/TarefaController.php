<?php

namespace Domain\Tarefa;

use Domain\Tarefa\Requests\StoreRequest;
use Domain\Tarefa\Requests\UpdateRequest;
use Domain\Tarefa\TarefaRepository as Repository;
use Illuminate\Http\Request;
use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;

class TarefaController extends AbstractController
{
    use GetsTrait, DeletesTrait;

    public function repo()
    {
        return Repository::class;
    }

    /**
     * @param TarefaService $service
     * @param StoreRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(TarefaService $service, StoreRequest $request)
    {
        return handleResponses($service->store($request->all()));
    }

    /**
     * @param TarefaService $service
     * @param int $ref_tarefa
     * @param UpdateRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(TarefaService $service, int $ref_tarefa, UpdateRequest $request)
    {
        return handleResponses($service->update($request->all(), $ref_tarefa));
    }

    /**
     * @param TarefaService $service
     * @param int $ref_tarefa
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function iniciar(TarefaService $service, int $ref_tarefa)
    {
        return handleResponses($service->iniciar($ref_tarefa));
    }

    /**
     * @param TarefaService $service
     * @param int $ref_tarefa
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function pausar(TarefaService $service, int $ref_tarefa, Request $request)
    {
        return handleResponses($service->pausar($ref_tarefa, $request->all()));
    }

    /**
     * @param TarefaService $service
     * @param int $ref_tarefa
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function finalizar(TarefaService $service, int $ref_tarefa)
    {
        return handleResponses($service->finalizar($ref_tarefa));
    }

    /**
     * @param TarefaService $service
     * @param int $ref_tarefa
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function reabrir(TarefaService $service, int $ref_tarefa)
    {
        return handleResponses($service->reabrir($ref_tarefa));
    }

    /**
     * @param TarefaService $service
     * @param int $ref_tarefa
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function duplicar(TarefaService $service, int $ref_tarefa)
    {
        return handleResponses($service->duplicar($ref_tarefa));
    }

    /**
     * @param TarefaService $service
     * @param int $ref_tarefa
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function arquivar(TarefaService $service, int $ref_tarefa)
    {
        return handleResponses($service->arquivar($ref_tarefa));
    }

    /**
     * @param TarefaService $service
     * @param int $ref_tarefa
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function atualizarSituacao(TarefaService $service, int $ref_tarefa, Request $request)
    {
        return handleResponses($service->atualizarSituacao($ref_tarefa, $request->all()));
    }

    /**
     * @param TarefaService $service
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function reordenar(TarefaService $service, Request $request)
    {
        return handleResponses($service->reordenar($request->all()));
    }

    /**
     * @param TarefaService $service
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function tarefasPorPeriodo(TarefaService $service, Request $request)
    {
        return $service->pdfTarefasPorPeriodo($request->get('dt_inicial'), $request->get('dt_final'));
    }
}
