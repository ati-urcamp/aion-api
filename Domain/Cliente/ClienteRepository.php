<?php

namespace Domain\Cliente;

use Domain\Base\Repositories\BaseRepository;

class ClienteRepository extends BaseRepository
{
    public function model()
    {
        return Cliente::class;
    }
}
