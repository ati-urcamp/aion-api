<?php

namespace Domain\TarefaChecklist;

use Domain\Base\Repositories\BaseRepository;

class TarefaChecklistRepository extends BaseRepository
{
    public function model()
    {
        return TarefaChecklist::class;
    }
}
