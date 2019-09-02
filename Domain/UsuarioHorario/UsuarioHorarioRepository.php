<?php

namespace Domain\UsuarioHorario;

use Domain\Base\Repositories\BaseRepository;

class UsuarioHorarioRepository extends BaseRepository
{
    public function model()
    {
        return UsuarioHorario::class;
    }
}
