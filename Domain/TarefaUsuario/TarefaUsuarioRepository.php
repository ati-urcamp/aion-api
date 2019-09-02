<?php

namespace Domain\TarefaUsuario;

use Domain\Base\Repositories\BaseRepository;

class TarefaUsuarioRepository extends BaseRepository
{
    public function model()
    {
        return TarefaUsuario::class;
    }
}
