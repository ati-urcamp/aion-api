<?php

namespace Domain\Perfil;

use DB;
use Domain\PerfilPermissao\PerfilPermissaoRepository;
use Exception;

class PerfilService
{
    protected $repo;
    protected $permissaoRepo;

    public function __construct(PerfilRepository $repo, PerfilPermissaoRepository $permissaoRepo)
    {
        $this->repo = $repo;
        $this->permissaoRepo = $permissaoRepo;
    }

    /**
     * @param array $data
     * @return array|\Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public function store(array $data)
    {
        DB::beginTransaction();

        try {
            $perfil = $this->repo->store($data);

            // Insere as permissões do perfil
            if (isset($data['permissoes']) && is_array($data['permissoes'])) {
                foreach ($data['permissoes'] as $permissao) {
                    $this->permissaoRepo->store([
                        'ref_perfil' => $perfil->id,
                        'ref_permissao' => $permissao,
                    ]);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return $perfil;
    }

    /**
     * @param array $data
     * @param int $ref_perfil
     * @return array|\Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public function update(array $data, int $ref_perfil)
    {
        DB::beginTransaction();

        try {
            // Atualiza as permissões do perfil
            if (isset($data['permissoes']) && is_array($data['permissoes'])) {
                $this->permissaoRepo->deleteBy('ref_perfil', $ref_perfil);

                foreach ($data['permissoes'] as $permissao) {
                    $this->permissaoRepo->store([
                        'ref_perfil' => $ref_perfil,
                        'ref_permissao' => $permissao,
                    ]);
                }
            }

            $perfil = $this->repo->update($data, $ref_perfil);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return $perfil;
    }
}
