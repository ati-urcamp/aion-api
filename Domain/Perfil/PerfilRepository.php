<?php

namespace Domain\Perfil;

use Domain\Base\Repositories\BaseRepository;

class PerfilRepository extends BaseRepository
{
    public function model()
    {
        return Perfil::class;
    }
}
