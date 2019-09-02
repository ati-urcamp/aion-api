<?php

namespace Domain\ProjetoTipo;

class ProjetoTipoService
{
    protected $repo;

    public function __construct(ProjetoTipoRepository $repo)
    {
        $this->repo = $repo;
    }
}
