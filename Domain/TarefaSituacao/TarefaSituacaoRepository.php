<?php

namespace Domain\TarefaSituacao;

use DB;
use Domain\Base\Repositories\BaseRepository;

class TarefaSituacaoRepository extends BaseRepository
{
    public function model()
    {
        return TarefaSituacao::class;
    }

    public function buscarTotaisPorSituacao()
    {
        $sql = "select ts.id, 
                       ts.nome,
                       ts.fl_visivel,
                       ts.cor,
                       count(t.id) as total 
                from tarefas_situacoes ts 
                left join tarefas t on t.ref_tarefa_situacao = ts.id 
                group by ts.id, ts.nome, ts.fl_visivel, ts.cor 
                order by ts.ordem, ts.nome";

        return DB::connection('default')->select($sql);
    }
}
