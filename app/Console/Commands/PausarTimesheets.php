<?php

namespace App\Console\Commands;

use DB;
use Domain\Configuracao\ConfiguracaoRepository;
use Domain\Tarefa\TarefaRepository;
use Domain\Timesheet\TimesheetRepository;
use Exception;
use Illuminate\Console\Command;

class PausarTimesheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aion:pausar-timesheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pausa todos os timesheets inicializados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param TimesheetRepository $timesheetRepo
     * @param ConfiguracaoRepository $configuracaoRepo
     * @param TarefaRepository $tarefaRepo
     * @throws Exception
     */
    public function handle(TimesheetRepository $timesheetRepo,
                           ConfiguracaoRepository $configuracaoRepo,
                           TarefaRepository $tarefaRepo)
    {
        $situacaoPausar = $configuracaoRepo->buscarPorNome('TAREFA_SITUACAO_PAUSAR');
        $timesheets = $timesheetRepo->buscarInicializados();

        DB::beginTransaction();

        try {
            foreach ($timesheets as $timesheet) {
                $timesheet->dt_termino = now();
                $timesheet->observacao = 'Pausa automática. Esqueceu de pausar antes de ir embora?';
                $timesheet->save();

                $tarefa = $tarefaRepo->find($timesheet->ref_tarefa);
                $tarefa->ref_tarefa_situacao = $situacaoPausar;
                $tarefa->fl_pausada = true;
                $tarefa->save();
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        $this->info('Timesheets pausados com sucesso!');
    }
}
