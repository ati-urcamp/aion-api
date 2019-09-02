<?php

namespace Domain\Usuario;

use DB;
use Domain\Equipe\EquipeRepository;
use Domain\UsuarioHorario\UsuarioHorarioRepository;
use Domain\UsuarioPerfil\UsuarioPerfilRepository;
use Domain\UsuarioToken\UsuarioTokenRepository;
use Exception;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UsuarioService
{
    protected $repo;
    protected $tokenRepo;
    protected $horarioRepo;
    protected $perfilRepo;
    protected $equipeRepo;

    public function __construct(UsuarioRepository $repo,
                                UsuarioTokenRepository $tokenRepo,
                                UsuarioHorarioRepository $horarioRepo,
                                UsuarioPerfilRepository $perfilRepo,
                                EquipeRepository $equipeRepo)
    {
        $this->repo = $repo;
        $this->tokenRepo = $tokenRepo;
        $this->horarioRepo = $horarioRepo;
        $this->perfilRepo = $perfilRepo;
        $this->equipeRepo = $equipeRepo;
    }

    /**
     * @param array $data
     * @return array|mixed
     */
    public function login(array $data)
    {
        try {
            $usuario = $this->repo->findOneBy('login', $data['login']);

            if (!$usuario) {
                return [
                    'error' => 'Usuário não encontrado.',
                    'code' => 401
                ];
            }

            if (!$usuario->fl_ativo) {
                return [
                    'error' => 'Usuário inativo, contate o administrador do sistema.',
                    'code' => 401
                ];
            }

            if (!Hash::check($data['password'], $usuario->senha) || !$token = JWTAuth::fromUser($usuario)) {
                return [
                    'error' => 'Login ou Senha incorretos.',
                    'code' => 401
                ];
            }

            $usuario->tokens()->create([
                'token' => $token,
                'fl_ativo' => true,
            ]);

            // Pega as permissões do usuário
            $usuario->load('perfis.permissoes');
            $permissoes = [];

            if (!$usuario->perfis->isEmpty()) {
                foreach ($usuario->perfis as $perfil) {
                    if (!$perfil->permissoes->isEmpty()) {
                        foreach ($perfil->permissoes as $permissao) {
                            $permissoes[] = $permissao->nome;
                        }
                    }
                }
            }

            $usuario->permissoes = array_unique($permissoes);
            unset($permissoes, $usuario->perfis);

            $usuario->permissoes_equipes = $this->buscarEquipesPermitidas($usuario);

            return [
                'usuario' => $usuario,
                'token' => $token,
            ];
        } catch (JWTException $e) {
            return [
                'error' => $e->getMessage(),
                'code' => 500
            ];
        }
    }

    public function logout()
    {
        $usuario = auth()->user();

        if ($usuario) {
            $this->tokenRepo->desativarPorUsuario($usuario->id, JWTAuth::getToken());
            auth()->logout();
        }

        return true;
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
            $usuario = $this->repo->store($data);

            // Insere os horários do usuário
            if (isset($data['horarios']) && is_array($data['horarios'])) {
                foreach ($data['horarios'] as $horario) {
                    $horario['ref_usuario'] = $usuario->id;

                    $this->horarioRepo->store($horario);
                }
            }

            // Insere os perfis do usuário
            if (isset($data['perfis']) && is_array($data['perfis'])) {
                foreach ($data['perfis'] as $perfil) {
                    $this->perfilRepo->store([
                        'ref_usuario' => $usuario->id,
                        'ref_perfil' => $perfil,
                    ]);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return $usuario;
    }

    /**
     * @param array $data
     * @param int $ref_usuario
     * @return array|\Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public function update(array $data, int $ref_usuario)
    {
        DB::beginTransaction();

        try {
            // Atualiza os horários do usuário
            if (isset($data['horarios']) && is_array($data['horarios'])) {
                $this->horarioRepo->deleteBy('ref_usuario', $ref_usuario);

                foreach ($data['horarios'] as $horario) {
                    $horario['ref_usuario'] = $ref_usuario;

                    $this->horarioRepo->store($horario);
                }
            }

            // Atualiza os perfis do usuário
            if (isset($data['perfis']) && is_array($data['perfis'])) {
                $this->perfilRepo->deleteBy('ref_usuario', $ref_usuario);

                foreach ($data['perfis'] as $perfil) {
                    $this->perfilRepo->store([
                        'ref_usuario' => $ref_usuario,
                        'ref_perfil' => $perfil,
                    ]);
                }
            }

            // Desativa os tokens do usuário
            if (!$data['fl_ativo']) {
                $this->tokenRepo->desativarPorUsuario($ref_usuario);
            }

            $usuario = $this->repo->update($data, $ref_usuario);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return $usuario;
    }

    public function buscarEquipesPermitidas($usuario)
    {
        $equipesPermitidas = [];
        $equipes = $this->equipeRepo->buscarEquipeIncluindoDescendentes($usuario->ref_equipe);

        if (!$equipes->isEmpty()) {
            $equipesPermitidas = $equipes->map(function ($equipe) {
                return $equipe->id;
            });
        }

        return $equipesPermitidas;
    }
}
