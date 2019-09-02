<?php

namespace Domain\TarefaEquipe;

use Domain\Base\Repositories\BaseRepository;

class TarefaEquipeRepository extends BaseRepository
{
    public function model()
    {
        return TarefaEquipe::class;
    }
}
