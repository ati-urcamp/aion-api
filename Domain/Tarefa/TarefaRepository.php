<?php

namespace Domain\Tarefa;

use DB;
use Domain\Usuario\UsuarioService;
use Domain\Base\Repositories\BaseRepository;

class TarefaRepository extends BaseRepository
{
    /**
     * @var UsuarioService
     */
    private $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        parent::__construct();

        $this->usuarioService = $usuarioService;
    }

    public function model()
    {
        return Tarefa::class;
    }

    public function doSearch(array $data, array $options = [])
    {
        $model = $this->prepareSearch($data, $options);

        // Filtra as tarefas pegando as do usuário ou das equipes que ele tem permissão
        $usuario = auth()->user();
        $equipesPermitidas = $this->usuarioService->buscarEquipesPermitidas($usuario);

        $model = $model->where(function ($query) use ($equipesPermitidas, $usuario) {
            $query->whereHas('equipes', function ($subquery) use ($equipesPermitidas) {
                $subquery->whereIn('tarefas_equipes.ref_equipe', $equipesPermitidas);
            });

            $query->orWhereHas('usuarios', function ($subquery) use ($usuario) {
                $subquery->where('tarefas_usuarios.ref_usuario', $usuario->id);
            });
        });

        // Getting options for paginator
        $limit = isset($options['_limit']) && $options['_limit'] === 'all' ? null : ($options['_limit'] ?? 20);
        $columns = $options['_columns'] ?? ['*'];

        if (!$limit) {
            return $model->get($columns);
        }

        return $model->paginate($limit, $columns, '_page');
    }

    public function buscarTarefasPorPeriodo($dt_inicial, $dt_final)
    {
        $dt_inicial = $dt_inicial . ' 00:00:00';
        $dt_final = $dt_final . ' 23:59:59';

        $sql = "select  p.id as ref_projeto,
                        p.nome as projeto,
                        c.nome as cliente,
                        c.responsavel,
                        t.id as ref_tarefa,
                        t.titulo as tarefa,
                        t.dt_criacao::date as dt_criacao_tarefa,
                        t.ref_tarefa_tipo,
                        tt.nome as tarefa_tipo,
                        t.ref_tarefa_situacao,
                        ts.nome as tarefa_situacao,
                        ts.cor as cor_tarefa_situacao,
                        coalesce((select sum(((date_part('day', coalesce(dt_termino, now()) - dt_inicio) * 24 + 
                                               date_part('hour', coalesce(dt_termino, now()) - dt_inicio)) * 60 + 
                                               date_part('minute', coalesce(dt_termino, now()) - dt_inicio)) * 60 + 
                                               date_part('second', coalesce(dt_termino, now()) - dt_inicio))
                                  from timesheets 
                                  where ref_tarefa = t.id
                                    and dt_inicio between ? and ?
                                  group by ref_tarefa), 0) as total_segundos_periodo,
                        (select round(sum((((((date_part('day', coalesce(dt_termino, now()) - dt_inicio) * 24 + 
                                               date_part('hour', coalesce(dt_termino, now()) - dt_inicio)) * 60 + 
                                               date_part('minute', coalesce(dt_termino, now()) - dt_inicio)) * 60 + 
                                               date_part('second', coalesce(dt_termino, now()) - dt_inicio)) / 3600) * usuarios.valor_hora)::numeric), 2)
                         from timesheets 
                         join usuarios on usuarios.id = timesheets.ref_usuario
                         where ref_tarefa = t.id
                           and dt_inicio between ? and ?
                         group by ref_tarefa) as valor_periodo
                from projetos p 
                join clientes c on c.id = p.ref_cliente
                join tarefas t on t.ref_projeto = p.id
                join tarefas_tipos tt on tt.id = t.ref_tarefa_tipo
                join tarefas_situacoes ts on ts.id = t.ref_tarefa_situacao
                where exists (
                    select true
                    from timesheets
                    where dt_inicio between ? and ?
                      and ref_tarefa = t.id
                )
                order by projeto, dt_criacao_tarefa, tarefa, tarefa_situacao";

        return DB::connection('default')->select($sql, [$dt_inicial, $dt_final, $dt_inicial, $dt_final, $dt_inicial, $dt_final]);
    }

    public function buscarTotalizacaoTarefasProjetoAnterioresPeriodo($ref_projeto, $dt_inicial)
    {
        $dt_inicial = $dt_inicial . ' 00:00:00';

        $sql = "select  t.ref_projeto,
                        sum(coalesce((select sum(((date_part('day', coalesce(dt_termino, now()) - dt_inicio) * 24 + 
                                                   date_part('hour', coalesce(dt_termino, now()) - dt_inicio)) * 60 + 
                                                   date_part('minute', coalesce(dt_termino, now()) - dt_inicio)) * 60 + 
                                                   date_part('second', coalesce(dt_termino, now()) - dt_inicio))
                                      from timesheets 
                                      where ref_tarefa = t.id
                                        and dt_inicio < ?
                                      group by ref_tarefa), 0)) as total_segundos_anteriores,
                        sum((select round(sum((((((date_part('day', coalesce(dt_termino, now()) - dt_inicio) * 24 + 
                                               date_part('hour', coalesce(dt_termino, now()) - dt_inicio)) * 60 + 
                                               date_part('minute', coalesce(dt_termino, now()) - dt_inicio)) * 60 + 
                                               date_part('second', coalesce(dt_termino, now()) - dt_inicio)) / 3600) * usuarios.valor_hora)::numeric), 2)
                         from timesheets 
                         join usuarios on usuarios.id = timesheets.ref_usuario
                         where ref_tarefa = t.id
                           and dt_inicio < ?
                         group by ref_tarefa)) as valor_anteriores
                from tarefas t
                where t.ref_projeto = ?
                  and exists (
                    select true
                    from timesheets
                    where dt_inicio < ?
                      and ref_tarefa = t.id
                  )
                group by t.ref_projeto";

        return collect(DB::connection('default')->select($sql, [$dt_inicial, $dt_inicial, $ref_projeto, $dt_inicial]))->first();
    }

    public function buscarTarefasProximoPeriodo($ref_projeto, $dt_inicial, $dt_final)
    {
        $dt_inicial = $dt_inicial . ' 00:00:00';
        $dt_final = $dt_final . ' 23:59:59';

        $sql = "select  t.id,
                        t.titulo,
                        t.ref_tarefa_tipo,
                        tt.nome as tarefa_tipo
                from tarefas t
                join tarefas_tipos tt on tt.id = t.ref_tarefa_tipo
                where t.ref_projeto = ?
                  and t.ref_tarefa_situacao not in (
                    select valor::integer
                    from configuracoes
                    where nome in ('TAREFA_SITUACAO_FINALIZAR', 'TAREFA_SITUACAO_ARQUIVAR')
                  )
                  and not exists (
                    select true
                    from timesheets
                    where dt_inicio between ? and ?
                      and ref_tarefa = t.id
                  )
                order by tarefa_tipo, titulo";

        return DB::connection('default')->select($sql, [$ref_projeto, $dt_inicial, $dt_final]);
    }
}
