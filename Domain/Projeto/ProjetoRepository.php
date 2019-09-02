<?php

namespace Domain\Projeto;

use Domain\Base\Repositories\BaseRepository;

class ProjetoRepository extends BaseRepository
{
    public function model()
    {
        return Projeto::class;
    }
}
