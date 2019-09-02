<?php

namespace Domain\TarefaUsuario;

use Domain\Base\Models\BaseModel;
use Domain\Tarefa\Tarefa;
use Domain\Usuario\Usuario;

class TarefaUsuario extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'tarefas_usuarios';

    public $timestamps = false;

    protected $fillable = [
        'ref_tarefa',
        'ref_usuario',
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
