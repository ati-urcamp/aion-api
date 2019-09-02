<?php

namespace Domain\Tarefa;

use Domain\TarefaChecklist\TarefaChecklist;
use Domain\Base\Models\BaseModel;
use Domain\Equipe\Equipe;
use Domain\Projeto\Projeto;
use Domain\TarefaSituacao\TarefaSituacao;
use Domain\TarefaTipo\TarefaTipo;
use Domain\Timesheet\Timesheet;
use Domain\Timesheet\TimesheetRepository;
use Domain\Usuario\Usuario;

class Tarefa extends BaseModel
{
    const CREATED_AT = 'dt_criacao';
    const UPDATED_AT = 'dt_modificacao';

    protected $connection = 'default';
    protected $table = 'tarefas';

    protected $fillable = [
        'titulo',
        'descricao',
        'tags',
        'ref_tarefa_tipo',
        'ref_tarefa_situacao',
        'ref_projeto',
        'esforco_estimado',
        'dt_desejada',
        'fl_iniciada',
        'fl_pausada',
        'fl_finalizada',
        'ordem',
    ];

    protected $searchFillable = [
        'titulo',
        'ref_tarefa_tipo',
        'ref_tarefa_situacao',
        'ref_projeto',
        'dt_desejada',
        'ref_usuario_timesheet',
    ];

    protected $appends = [
        'duracao',
    ];

    protected $casts = [
        'fl_iniciada' => 'boolean',
        'fl_pausada' => 'boolean',
        'fl_finalizada' => 'boolean',
    ];

    protected $dates = [
        'dt_desejada',
    ];

    public function tipo()
    {
        return $this->belongsTo(TarefaTipo::class, 'ref_tarefa_tipo');
    }

    public function situacao()
    {
        return $this->belongsTo(TarefaSituacao::class, 'ref_tarefa_situacao');
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class, 'ref_projeto');
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class, 'ref_tarefa')->orderBy('dt_inicio', 'desc');
    }

    public function ultimo_timesheet()
    {
        return $this->hasOne(Timesheet::class, 'ref_tarefa')->orderBy('dt_inicio', 'desc');
    }

    public function primeiro_timesheet()
    {
        return $this->hasOne(Timesheet::class, 'ref_tarefa')->orderBy('dt_inicio', 'asc');
    }

    public function usuario_timesheet()
    {
        return $this->belongsTo(Usuario::class, 'ref_usuario_timesheet');
    }

    public function usuario_finalizado()
    {
        return $this->belongsTo(Usuario::class, 'ref_usuario_finalizado');
    }

    public function usuario_reaberto()
    {
        return $this->belongsTo(Usuario::class, 'ref_usuario_reaberto');
    }

    public function equipes()
    {
        return $this->belongsToMany(Equipe::class, 'tarefas_equipes', 'ref_tarefa', 'ref_equipe');
    }

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'tarefas_usuarios', 'ref_tarefa', 'ref_usuario');
    }

    public function checklist()
    {
        return $this->hasMany(TarefaChecklist::class, 'ref_tarefa');
    }

    public function getTagsAttribute()
    {
        return !empty($this->attributes['tags']) ? explode('|', $this->attributes['tags']) : null;
    }

    public function setTagsAttribute($tags)
    {
        $this->attributes['tags'] = !empty($tags) ? implode('|', $tags) : null;
    }

    public function getDuracaoAttribute()
    {
        $timesheetRepo = app()->make(TimesheetRepository::class);
        $duracao = $timesheetRepo->buscarDuracaoPorTarefa($this->attributes['id']);

        return [
            'total_em_segundos' => $duracao->total_em_segundos ?? 0,
            'total_humanizado' => $duracao->total_humanizado ?? '00:00:00',
        ];
    }
}
