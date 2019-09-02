<?php

namespace Domain\Tarefa;

use DB;
use Domain\Configuracao\ConfiguracaoRepository;
use Domain\Pessoa\Pessoa;
use Domain\TarefaEquipe\TarefaEquipeRepository;
use Domain\TarefaUsuario\TarefaUsuarioRepository;
use Domain\Timesheet\TimesheetRepository;
use Exception;
use PDF;

class TarefaService
{
    protected $repo;
    protected $equipeRepo;
    protected $usuarioRepo;
    protected $timesheetRepo;
    protected $configuracaoRepo;

    public function __construct(TarefaRepository $repo,
                                TarefaEquipeRepository $equipeRepo,
                                TarefaUsuarioRepository $usuarioRepo,
                                TimesheetRepository $timesheetRepo,
                                ConfiguracaoRepository $configuracaoRepo)
    {
        $this->repo = $repo;
        $this->equipeRepo = $equipeRepo;
        $this->usuarioRepo = $usuarioRepo;
        $this->timesheetRepo = $timesheetRepo;
        $this->configuracaoRepo = $configuracaoRepo;
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
            $tarefa = $this->repo->store($data);

            // Insere as equipes da tarefa
            if (isset($data['equipes']) && is_array($data['equipes'])) {
                foreach ($data['equipes'] as $equipe) {
                    $this->equipeRepo->store([
                        'ref_tarefa' => $tarefa->id,
                        'ref_equipe' => $equipe,
                    ]);
                }
            }

            // Insere os usuários da tarefa
            if (isset($data['usuarios']) && is_array($data['usuarios'])) {
                foreach ($data['usuarios'] as $usuario) {
                    $this->usuarioRepo->store([
                        'ref_tarefa' => $tarefa->id,
                        'ref_usuario' => $usuario,
                    ]);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return $tarefa;
    }

    /**
     * @param array $data
     * @param int $ref_tarefa
     * @return array|\Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public function update(array $data, int $ref_tarefa)
    {
        DB::beginTransaction();

        try {
            // Atualiza as equipes da tarefa
            if (isset($data['equipes']) && is_array($data['equipes'])) {
                $this->equipeRepo->deleteBy('ref_tarefa', $ref_tarefa);

                foreach ($data['equipes'] as $equipe) {
                    $this->equipeRepo->store([
                        'ref_tarefa' => $ref_tarefa,
                        'ref_equipe' => $equipe,
                    ]);
                }
            }

            // Atualiza os usuários da tarefa
            if (isset($data['usuarios']) && is_array($data['usuarios'])) {
                $this->usuarioRepo->deleteBy('ref_tarefa', $ref_tarefa);

                foreach ($data['usuarios'] as $usuario) {
                    $this->usuarioRepo->store([
                        'ref_tarefa' => $ref_tarefa,
                        'ref_usuario' => $usuario,
                    ]);
                }
            }
            unset($data['fl_iniciada']);
            unset($data['fl_pausada']);
            unset($data['fl_finalizada']);

            $tarefa = $this->repo->update($data, $ref_tarefa);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return $tarefa;
    }

    /**
     * @param $ref_tarefa
     * @return array|mixed
     * @throws Exception
     */
    public function iniciar($ref_tarefa)
    {
        $usuario = auth()->user();
        $situacao = $this->configuracaoRepo->buscarPorNome('TAREFA_SITUACAO_INICIAR');

        if ($this->timesheetRepo->temInicializadosPorUsuario($usuario->id)) {
            return [
                'error' => 'Você já está trabalhando em outra tarefa',
                'code' => 400,
            ];
        }

        $tarefa = $this->repo->find($ref_tarefa);

        if ($tarefa->fl_finalizada) {
            return [
                'error' => 'Essa tarefa já foi finalizada',
                'code' => 400,
            ];
        }

        if ($tarefa->fl_iniciada && !$tarefa->fl_pausada) {
            return [
                'error' => 'Já existe usuário trabalhando nessa tarefa',
                'code' => 400,
            ];
        }

        DB::beginTransaction();

        try {
            $this->timesheetRepo->store([
                'ref_tarefa' => $ref_tarefa,
                'ref_usuario' => $usuario->id,
                'dt_inicio' => now(),
            ]);

            $tarefa->ref_tarefa_situacao = $situacao;
            $tarefa->fl_iniciada = true;
            $tarefa->fl_pausada = false;
            $tarefa->ref_usuario_timesheet = $usuario->id;
            $tarefa->save();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return $this->repo->get($ref_tarefa, ['*'], ['tipo', 'situacao', 'projeto', 'equipes', 'usuarios', 'timesheets.usuario', 'checklist']);
    }

    /**
     * @param $ref_tarefa
     * @param array $data
     * @return array|mixed
     * @throws Exception
     */
    public function pausar($ref_tarefa, array $data)
    {
        $tarefa = $this->repo->find($ref_tarefa);

        if ($tarefa->fl_finalizada) {
            return [
                'error' => 'Essa tarefa já foi finalizada',
                'code' => 400,
            ];
        }

        if (!$tarefa->fl_iniciada) {
            return [
                'error' => 'Ninguém iniciou a trabalhar ainda nessa tarefa',
                'code' => 400,
            ];
        }

        $usuario = auth()->user();

        if ($usuario->id != $tarefa->ref_usuario_timesheet) {
            return [
                'error' => 'Somente o usuário que iniciou pode parar o andamento desta tarefa',
                'code' => 400,
            ];
        }

        $timesheet = $this->timesheetRepo->buscarInicializadaPorTarefa($ref_tarefa);
        $situacao = $this->configuracaoRepo->buscarPorNome('TAREFA_SITUACAO_PAUSAR');

        DB::beginTransaction();

        try {
            $this->timesheetRepo->update([
                'dt_termino' => now(),
                'observacao' => (isset($data['observacao']) && $data['observacao']) ? $data['observacao'] : null
            ], $timesheet->id);

            $tarefa->ref_tarefa_situacao = $situacao;
            $tarefa->fl_pausada = true;
            $tarefa->save();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return $this->repo->get($ref_tarefa, ['*'], ['tipo', 'situacao', 'projeto', 'equipes', 'usuarios', 'timesheets.usuario', 'checklist']);
    }

    /**
     * @param $ref_tarefa
     * @return array|mixed
     * @throws Exception
     */
    public function finalizar($ref_tarefa)
    {
        $tarefa = $this->repo->find($ref_tarefa);

        if ($tarefa->fl_finalizada) {
            return [
                'error' => 'Essa tarefa já foi finalizada',
                'code' => 400,
            ];
        }

        $usuario = auth()->user();
        $situacao = $this->configuracaoRepo->buscarPorNome('TAREFA_SITUACAO_FINALIZAR');

        DB::beginTransaction();

        try {
            $timesheet = $this->timesheetRepo->buscarInicializadaPorTarefa($ref_tarefa);

            if ($timesheet) {
                if (!$tarefa->fl_pausada && $usuario->id != $tarefa->ref_usuario_timesheet) {
                    return [
                        'error' => 'Somente o usuário que iniciou pode finalizar essa tarefa',
                        'code' => 400,
                    ];
                }

                if (!$tarefa->fl_pausada) {
                    $this->timesheetRepo->update([
                        'dt_termino' => now(),
                    ], $timesheet->id);
                }
            } else {
                // Tem de existir ao menos uma entrada na timesheet para registro de finalização
                $this->timesheetRepo->store([
                    'ref_tarefa' => $ref_tarefa,
                    'ref_usuario' => $usuario->id,
                    'dt_inicio' => now(),
                    'dt_termino' => now(),
                ]);
            }

            // Se foi reaberto, vincula o usuário que solicitou a finalização
            if (!$tarefa->ref_usuario_timesheet) {
                $tarefa->ref_usuario_timesheet = $usuario->id;
            }

            $tarefa->ref_tarefa_situacao = $situacao;
            $tarefa->fl_iniciada = false;
            $tarefa->fl_pausada = false;
            $tarefa->fl_finalizada = true;
            $tarefa->ref_usuario_finalizado = $usuario->id;
            $tarefa->save();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return $this->repo->get($ref_tarefa, ['*'], ['tipo', 'situacao', 'projeto', 'equipes', 'usuarios', 'timesheets.usuario', 'checklist']);
    }

    /**
     * @param $ref_tarefa
     * @return array|mixed
     * @throws Exception
     */
    public function reabrir($ref_tarefa)
    {
        $tarefa = $this->repo->find($ref_tarefa);

        if (!$tarefa->fl_finalizada) {
            return [
                'error' => 'Essa tarefa ainda não foi finalizada',
                'code' => 400,
            ];
        }

        $situacao = $this->configuracaoRepo->buscarPorNome('TAREFA_SITUACAO_REABRIR');

        $tarefa->ref_tarefa_situacao = $situacao;
        $tarefa->fl_iniciada = false;
        $tarefa->fl_pausada = false;
        $tarefa->fl_finalizada = false;
        $tarefa->ref_usuario_timesheet = null;
        $tarefa->ref_usuario_finalizado = null;
        $tarefa->ref_usuario_reaberto = auth()->user()->id;
        $tarefa->save();

        return $this->repo->get($ref_tarefa, ['*'], ['tipo', 'situacao', 'projeto', 'equipes', 'usuarios', 'timesheets.usuario', 'checklist']);
    }

    /**
     * @param $ref_tarefa
     * @return array|mixed
     * @throws Exception
     */
    public function duplicar($ref_tarefa)
    {
        $tarefa = $this->repo->find($ref_tarefa);

        $situacaoCriada = $this->configuracaoRepo->buscarPorNome('TAREFA_SITUACAO_REABRIR');
        $tarefaDuplicada = $tarefa->replicate();
        $tarefaDuplicada->push();

        $tarefaDuplicada->titulo = '(Cópia) ' . $tarefa->titulo;
        $tarefaDuplicada->ref_tarefa_situacao = $situacaoCriada;
        $tarefaDuplicada->fl_iniciada = false;
        $tarefaDuplicada->fl_pausada = false;
        $tarefaDuplicada->fl_finalizada = false;
        $tarefaDuplicada->ref_usuario_timesheet = null;
        $tarefaDuplicada->ref_usuario_finalizado = null;
        $tarefaDuplicada->ref_usuario_reaberto = null;
        $tarefaDuplicada->save();

        foreach ($tarefa->equipes as $equipe) {
            $this->equipeRepo->store([
                'ref_tarefa' => $tarefaDuplicada->id,
                'ref_equipe' => $equipe->id
            ]);
        }

        foreach ($tarefa->usuarios as $usuario) {
            $this->usuarioRepo->store([
                'ref_tarefa' => $tarefaDuplicada->id,
                'ref_usuario' => $usuario->id
            ]);
        }

        $tarefa = $this->repo->find($tarefaDuplicada->id);

        return $tarefa;
    }

    /**
     * @param $ref_tarefa
     * @return array|mixed
     * @throws Exception
     */
    public function arquivar($ref_tarefa)
    {
        $tarefa = $this->repo->find($ref_tarefa);

        if (!$tarefa->fl_finalizada) {
            return [
                'error' => 'Essa tarefa tem de estar finalizada para poder ser arquivada',
                'code' => 400,
            ];
        }

        $situacao = $this->configuracaoRepo->buscarPorNome('TAREFA_SITUACAO_ARQUIVAR');

        $tarefa->ref_tarefa_situacao = $situacao;
        $tarefa->save();

        return $this->repo->get($ref_tarefa, ['*'], ['tipo', 'situacao', 'projeto', 'equipes', 'usuarios', 'timesheets.usuario', 'checklist']);
    }

    /**
     * @param $ref_tarefa
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function atualizarSituacao($ref_tarefa, array $data)
    {
        $tarefa = $this->repo->find($ref_tarefa);

        $tarefa->ref_tarefa_situacao = $data['ref_tarefa_situacao'];
        $tarefa->save();

        return $tarefa;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function reordenar(array $data)
    {
        $i = 0;

        foreach ($data['tarefas'] as $ref_tarefa) {
            $tarefa = $this->repo->find($ref_tarefa);
            $tarefa->ordem = $i;
            $tarefa->save();

            $i++;
        }

        return true;
    }

    public function pdfTarefasPorPeriodo($dt_inicial, $dt_final)
    {
        $tarefas = $this->repo->buscarTarefasPorPeriodo($dt_inicial, $dt_final);
        $projetos = [];

        foreach ($tarefas as $tarefa) {
            if (!isset($projetos[$tarefa->ref_projeto])) {
                $projetos[$tarefa->ref_projeto] = [
                    'id' => $tarefa->ref_projeto,
                    'nome' => $tarefa->projeto,
                    'cliente' => $tarefa->cliente,
                    'responsavel' => $tarefa->responsavel,
                    'tarefas' => [],
                    'total_segundos_periodo' => 0,
                    'total_periodo_humanizado' => '',
                    'valor_periodo' => 0,
                    'total_segundos_anteriores' => 0,
                    'total_anteriores_humanizado' => '',
                    'valor_anteriores' => 0,
                    'total_segundos_geral' => 0,
                    'total_geral_humanizado' => '',
                    'valor_geral' => 0,
                ];
            }

            $projetos[$tarefa->ref_projeto]['tarefas'][] = [
                'id' => $tarefa->ref_tarefa,
                'titulo' => $tarefa->tarefa,
                'dt_criacao' => $tarefa->dt_criacao_tarefa,
                'ref_tarefa_tipo' => $tarefa->ref_tarefa_tipo,
                'tipo' => $tarefa->tarefa_tipo,
                'ref_tarefa_situacao' => $tarefa->ref_tarefa_situacao,
                'situacao' => $tarefa->tarefa_situacao,
                'cor_situacao' => $tarefa->cor_tarefa_situacao,
                'total_segundos_periodo' => $tarefa->total_segundos_periodo,
                'total_periodo_humanizado' => convertSecondsToHours($tarefa->total_segundos_periodo),
                'valor_periodo' => $tarefa->valor_periodo,
            ];

            $projetos[$tarefa->ref_projeto]['total_segundos_periodo'] += $tarefa->total_segundos_periodo;
            $projetos[$tarefa->ref_projeto]['valor_periodo'] += $tarefa->valor_periodo;
        }

        // Totalização tarefas anteriores
        foreach ($projetos as $indice_projeto => $projeto) {
            $totalizacao_projeto = $this->repo->buscarTotalizacaoTarefasProjetoAnterioresPeriodo($projeto['id'], $dt_inicial);

            if ($totalizacao_projeto) {
                $projetos[$indice_projeto]['total_segundos_anteriores'] += $totalizacao_projeto->total_segundos_anteriores;
                $projetos[$indice_projeto]['valor_anteriores'] += $totalizacao_projeto->valor_anteriores;
            }

            $projetos[$indice_projeto]['proximas_tarefas'] = $this->repo->buscarTarefasProximoPeriodo($projeto['id'], $dt_inicial, $dt_final);
        }

        $projetos = array_map(function ($projeto) {
            $projeto['total_segundos_geral'] = $projeto['total_segundos_periodo'] + $projeto['total_segundos_anteriores'];
            $projeto['valor_geral'] = $projeto['valor_periodo'] + $projeto['valor_anteriores'];

            $projeto['total_periodo_humanizado'] = convertSecondsToHours($projeto['total_segundos_periodo']);
            $projeto['total_anteriores_humanizado'] = convertSecondsToHours($projeto['total_segundos_anteriores']);
            $projeto['total_geral_humanizado'] = convertSecondsToHours($projeto['total_segundos_geral']);

            return $projeto;
        }, $projetos);

        $projetos = array_values($projetos);

        return [
            'arquivo' => base64_encode(PDF::loadView('relatorios.tarefas-por-periodo', compact('projetos', 'dt_inicial', 'dt_final'), [], [
                'format' => 'A4',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 24,
                'margin_bottom' => 16,
                'margin_header' => 9,
                'margin_footer' => 9,
                'title' => 'Tarefas por período',
            ])->output()),
        ];
    }
}
