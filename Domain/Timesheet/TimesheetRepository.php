<?php

namespace Domain\Timesheet;

use DB;
use Domain\Base\Repositories\BaseRepository;

class TimesheetRepository extends BaseRepository
{
    public function model()
    {
        return Timesheet::class;
    }

    public function temInicializadosPorUsuario(int $ref_usuario)
    {
        return !!$this->getModel()
            ->where('ref_usuario', $ref_usuario)
            ->whereNull('dt_termino')
            ->first();
    }

    public function buscarInicializadaPorTarefa(int $ref_tarefa)
    {
        return $this->getModel()
            ->where('ref_tarefa', $ref_tarefa)
            ->whereNull('dt_termino')
            ->first();
    }

    public function buscarInicializados()
    {
        return $this->getModel()->whereNull('dt_termino')->get();
    }

    public function buscarDuracaoPorTarefa(int $ref_tarefa)
    {
        $sql = "SELECT SUM(((DATE_PART('day', COALESCE(dt_termino, NOW()) - dt_inicio) * 24 + 
                             DATE_PART('hour', COALESCE(dt_termino, NOW()) - dt_inicio)) * 60 + 
                             DATE_PART('minute', COALESCE(dt_termino, NOW()) - dt_inicio)) * 60 + 
                             DATE_PART('second', COALESCE(dt_termino, NOW()) - dt_inicio)) as total_em_segundos,
                       TO_CHAR((SUM(((DATE_PART('day', COALESCE(dt_termino, NOW()) - dt_inicio) * 24 + 
                                      DATE_PART('hour', COALESCE(dt_termino, NOW()) - dt_inicio)) * 60 + 
                                      DATE_PART('minute', COALESCE(dt_termino, NOW()) - dt_inicio)) * 60 + 
                                      DATE_PART('second', COALESCE(dt_termino, NOW()) - dt_inicio)) || ' second')::interval, 'HH24:MI:SS') as total_humanizado 
                FROM timesheets 
                WHERE ref_tarefa = ? 
                GROUP BY ref_tarefa";

        return collect(DB::connection('default')->select($sql, [$ref_tarefa]))->first();
    }

    public function buscarTotalHorasPeriodoGeral()
    {
        $sql = "SELECT d.dt_periodo,
                       COALESCE(t.total, 0) as total
                FROM (
                    SELECT generate_series(CURRENT_DATE - INTERVAL '30' DAY, CURRENT_DATE, '1 DAY')::date AS dt_periodo
                ) d
                LEFT JOIN (
                    SELECT dt_inicio::date,
                           ROUND((SUM(((DATE_PART('day', COALESCE(dt_termino, NOW()) - dt_inicio) * 24 + 
                                 DATE_PART('hour', COALESCE(dt_termino, NOW()) - dt_inicio)) * 60 + 
                                 DATE_PART('minute', COALESCE(dt_termino, NOW()) - dt_inicio)) * 60 + 
                                 DATE_PART('second', COALESCE(dt_termino, NOW()) - dt_inicio)) / 3600)::numeric, 2) AS total
                    FROM timesheets 
                    WHERE dt_inicio BETWEEN (NOW() - INTERVAL '30' DAY) AND NOW()
                    GROUP BY dt_inicio::date
                ) t ON t.dt_inicio = d.dt_periodo 
                ORDER BY d.dt_periodo";

        return DB::connection('default')->select($sql);
    }

    public function buscarTotalHorasPeriodoUsuarios()
    {
        $sql = "SELECT u.id,
                       u.nome,
                       COALESCE(t.total, 0) AS total
                FROM usuarios u
                LEFT JOIN (
                    SELECT ref_usuario,
                           ROUND((SUM(((DATE_PART('day', COALESCE(dt_termino, NOW()) - dt_inicio) * 24 + 
                                 DATE_PART('hour', COALESCE(dt_termino, NOW()) - dt_inicio)) * 60 + 
                                 DATE_PART('minute', COALESCE(dt_termino, NOW()) - dt_inicio)) * 60 + 
                                 DATE_PART('second', COALESCE(dt_termino, NOW()) - dt_inicio)) / 3600)::numeric, 2) AS total
                    FROM timesheets
                    WHERE dt_inicio BETWEEN (NOW() - INTERVAL '7' DAY) AND NOW()
                    GROUP BY ref_usuario
                ) AS t ON t.ref_usuario = u.id
                WHERE u.fl_ativo = 't'
                ORDER BY u.nome";

        return DB::connection('default')->select($sql);
    }

    public function buscarTotalHorasPeriodoUsuario()
    {
        $sql = "SELECT d.dt_periodo,
                       COALESCE(t.total, 0) as total
                FROM (
                    SELECT generate_series(CURRENT_DATE - INTERVAL '14' DAY, CURRENT_DATE, '1 DAY')::date AS dt_periodo
                ) d
                LEFT JOIN (
                    SELECT dt_inicio::date,
                           ROUND((SUM(((DATE_PART('day', COALESCE(dt_termino, NOW()) - dt_inicio) * 24 + 
                                 DATE_PART('hour', COALESCE(dt_termino, NOW()) - dt_inicio)) * 60 + 
                                 DATE_PART('minute', COALESCE(dt_termino, NOW()) - dt_inicio)) * 60 + 
                                 DATE_PART('second', COALESCE(dt_termino, NOW()) - dt_inicio)) / 3600)::numeric, 2) AS total
                    FROM timesheets 
                    WHERE dt_inicio BETWEEN (NOW() - INTERVAL '14' DAY) AND NOW()
                      AND ref_usuario = ?
                    GROUP BY dt_inicio::date
                ) t ON t.dt_inicio = d.dt_periodo 
                ORDER BY d.dt_periodo";

        return DB::connection('default')->select($sql, [auth()->user()->id]);
    }
}
