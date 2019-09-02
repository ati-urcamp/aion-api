<?php

namespace Domain\UsuarioToken;

use Domain\Base\Repositories\BaseRepository;

class UsuarioTokenRepository extends BaseRepository
{
    public function model()
    {
        return UsuarioToken::class;
    }

    public function desativarPorUsuario(int $ref_usuario, string $token = '')
    {
        $query = $this->getModel()
            ->where('ref_usuario', $ref_usuario)
            ->where('fl_ativo', true);

        if ($token) {
            $query = $query->where('token', $token);
        }

        return $query->update(['fl_ativo' => false]);
    }

    public function buscarAtivoPorUsuario(int $ref_usuario, string $token)
    {
        return $this->getModel()
            ->where('ref_usuario', $ref_usuario)
            ->where('token', $token)
            ->where('fl_ativo', true)->first();
    }
}
