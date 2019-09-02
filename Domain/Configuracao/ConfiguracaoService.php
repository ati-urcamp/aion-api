<?php

namespace Domain\Configuracao;

class ConfiguracaoService
{
    protected $repo;

    public function __construct(ConfiguracaoRepository $repo)
    {
        $this->repo = $repo;
    }
}
