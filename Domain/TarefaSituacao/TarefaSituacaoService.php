<?php

namespace Domain\TarefaSituacao;

class TarefaSituacaoService
{
    protected $repo;

    public function __construct(TarefaSituacaoRepository $repo)
    {
        $this->repo = $repo;
    }

    public function buscarTotaisPorSituacao()
    {
        return $this->repo->buscarTotaisPorSituacao();
    }
}
