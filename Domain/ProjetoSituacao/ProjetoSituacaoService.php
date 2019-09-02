<?php

namespace Domain\ProjetoSituacao;

class ProjetoSituacaoService
{
    protected $repo;

    public function __construct(ProjetoSituacaoRepository $repo)
    {
        $this->repo = $repo;
    }
}
