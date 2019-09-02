<?php

namespace Domain\Equipe;

class EquipeService
{
    protected $repo;

    public function __construct(EquipeRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param array $data
     * @return array|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function store(array $data)
    {
        $equipe = $this->repo->store($data);
        $arvore = $this->buscarArvore($equipe);

        $equipe->arvore = $arvore;
        $equipe->arvore_humanizada = implode(' > ', array_map(function ($item) {
            return $item['nome'];
        }, $arvore));

        $equipe->save();

        return $equipe;
    }

    /**
     * @param array $data
     * @param int $ref_equipe
     * @return array|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function update(array $data, int $ref_equipe)
    {
        $equipe = $this->repo->update($data, $ref_equipe);
        $arvore = $this->buscarArvore($equipe);

        $equipe->arvore = $arvore;
        $equipe->arvore_humanizada = implode(' > ', array_map(function ($item) {
            return $item['nome'];
        }, $arvore));

        $equipe->save();

        return $equipe;
    }

    /**
     * @param $equipe
     * @return array
     */
    private function buscarArvore($equipe)
    {
        $arvore = [
            ['id' => $equipe->id, 'nome' => $equipe->nome]
        ];

        if ($equipe->ref_equipe !== null) {
            do {
                $equipe = $this->repo->find($equipe->ref_equipe);

                $arvore[] = [
                    'id' => $equipe->id,
                    'nome' => $equipe->nome
                ];
            } while ($equipe && $equipe->ref_equipe);
        }

        return array_reverse($arvore);
    }
}
