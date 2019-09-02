<?php

namespace Domain\PerfilPermissao;

use Domain\Base\Repositories\BaseRepository;

class PerfilPermissaoRepository extends BaseRepository
{
    public function model()
    {
        return PerfilPermissao::class;
    }
}
