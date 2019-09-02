<?php

namespace Domain\Permissao;

use Domain\Base\Repositories\BaseRepository;

class PermissaoRepository extends BaseRepository
{
    public function model()
    {
        return Permissao::class;
    }
}
