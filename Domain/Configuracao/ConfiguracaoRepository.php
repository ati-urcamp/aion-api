<?php

namespace Domain\Configuracao;

use Domain\Base\Repositories\BaseRepository;

class ConfiguracaoRepository extends BaseRepository
{
    public function model()
    {
        return Configuracao::class;
    }

    public function buscarPorNome($nome)
    {
        return $this->getModel()->where('nome', $nome)->first()->valor ?? null;
    }
}
