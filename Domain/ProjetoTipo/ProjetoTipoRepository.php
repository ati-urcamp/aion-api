<?php

namespace Domain\ProjetoTipo;

use Domain\Base\Repositories\BaseRepository;

class ProjetoTipoRepository extends BaseRepository
{
    public function model()
    {
        return ProjetoTipo::class;
    }
}
