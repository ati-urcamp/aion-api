<?php

namespace Domain\Equipe;

use Domain\Base\Repositories\BaseRepository;

class EquipeRepository extends BaseRepository
{
    public function model()
    {
        return Equipe::class;
    }

    public function buscarEquipeIncluindoDescendentes($ref_equipe)
    {
        return $this->getModel()->where('arvore', 'like', '%"id":' . $ref_equipe . ',%')->get();
    }
}
