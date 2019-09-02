<?php

namespace Domain\TarefaTipo;

use DB;
use Domain\Configuracao\ConfiguracaoRepository;
use Domain\Base\Repositories\BaseRepository;

class TarefaTipoRepository extends BaseRepository
{
    public function model()
    {
        return TarefaTipo::class;
    }

    public function buscarTotaisPorTipo()
    {
        $configuracaoRepo = app()->make(ConfiguracaoRepository::class);
        $situacao = $configuracaoRepo->buscarPorNome('TAREFA_SITUACAO_ARQUIVAR');

        $sql = "select tt.id, 
                       tt.nome,
                       tt.cor,
                       count(t.id) as total 
                from tarefas_tipos tt 
                left join tarefas t on t.ref_tarefa_tipo = tt.id 
                where t.ref_tarefa_situacao <> ?
                group by tt.id, tt.nome, tt.cor 
                order by tt.nome";

        return DB::connection('default')->select($sql, [$situacao]);
    }
}
