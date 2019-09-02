<?php

namespace Domain\Projeto;

class ProjetoService
{
    protected $repo;

    public function __construct(ProjetoRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param $ref_projeto
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function atualizarSituacao($ref_projeto, array $data)
    {
        $projeto = $this->repo->find($ref_projeto);

        $projeto->ref_projeto_situacao = $data['ref_projeto_situacao'];
        $projeto->save();

        return $projeto;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function reordenar(array $data)
    {
        $i = 0;

        foreach ($data['projetos'] as $ref_projeto) {
            $projeto = $this->repo->find($ref_projeto);
            $projeto->ordem = $i;
            $projeto->save();

            $i++;
        }

        return true;
    }
}
