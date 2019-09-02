<?php

namespace Domain\UsuarioPerfil;

use Domain\Base\Repositories\BaseRepository;

class UsuarioPerfilRepository extends BaseRepository
{
    public function model()
    {
        return UsuarioPerfil::class;
    }
}
