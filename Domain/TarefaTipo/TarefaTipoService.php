<?php

namespace Domain\TarefaTipo;

class TarefaTipoService
{
    protected $repo;

    public function __construct(TarefaTipoRepository $repo)
    {
        $this->repo = $repo;
    }

    public function buscarTotaisPorTipo()
    {
        return $this->repo->buscarTotaisPorTipo();
    }
}
