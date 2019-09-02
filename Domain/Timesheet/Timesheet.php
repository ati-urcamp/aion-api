<?php

namespace Domain\Timesheet;

use Domain\Base\Models\BaseModel;
use Domain\Tarefa\Tarefa;
use Domain\Usuario\Usuario;

class Timesheet extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'timesheets';

    public $timestamps = false;

    protected $fillable = [
        'ref_tarefa',
        'ref_usuario',
        'dt_inicio',
        'dt_termino',
        'observacao',
    ];

    protected $searchFillable = [
        'ref_tarefa',
        'ref_usuario',
    ];

    protected $dates = [
        'dt_inicio',
        'dt_termino',
    ];

    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class, 'ref_tarefa');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'ref_usuario');
    }
}
