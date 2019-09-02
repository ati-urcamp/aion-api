<?php

namespace Domain\Cliente;

class ClienteService
{
    protected $repo;

    public function __construct(ClienteRepository $repo)
    {
        $this->repo = $repo;
    }
}
