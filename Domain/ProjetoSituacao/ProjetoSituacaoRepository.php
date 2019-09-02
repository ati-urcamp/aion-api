<?php

namespace Domain\ProjetoSituacao;

use Domain\Base\Repositories\BaseRepository;

class ProjetoSituacaoRepository extends BaseRepository
{
    public function model()
    {
        return ProjetoSituacao::class;
    }
}
