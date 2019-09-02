<?php

namespace Domain\UsuarioHorario;

use Domain\Base\Models\BaseModel;
use Domain\Usuario\Usuario;

class UsuarioHorario extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'usuarios_horarios';

    public $timestamps = false;

    protected $fillable = [
        'ref_usuario',
        'dia_semana',
        'hora_entrada',
        'hora_saida',
    ];

    protected $searchFillable = [];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'ref_usuario');
    }
}
