<?php

namespace Domain\Usuario;

use Domain\Base\Repositories\BaseRepository;

class UsuarioRepository extends BaseRepository
{
    public function model()
    {
        return Usuario::class;
    }

    public function temPermissao($permissao, $ref_usuario)
    {
        return !!$this->getModel()
            ->select('permissoes.*')
            ->join('usuarios_perfis', 'usuarios_perfis.ref_usuario', '=', 'usuarios.id')
            ->join('perfis_permissoes', 'perfis_permissoes.ref_perfil', '=', 'usuarios_perfis.ref_perfil')
            ->join('permissoes', 'permissoes.id', '=', 'perfis_permissoes.ref_permissao')
            ->where('usuarios.id', $ref_usuario)
            ->where('permissoes.nome', $permissao)
            ->first();
    }
}
