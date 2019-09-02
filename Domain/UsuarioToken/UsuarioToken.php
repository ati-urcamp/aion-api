<?php

namespace Domain\UsuarioToken;

use Domain\Base\Models\BaseModel;
use Domain\Usuario\Usuario;

class UsuarioToken extends BaseModel
{
    const CREATED_AT = 'dt_criacao';
    const UPDATED_AT = 'dt_modificacao';

    protected $connection = 'default';
    protected $table = 'usuarios_tokens';

    protected $fillable = [
        'ref_usuario',
        'token',
        'fl_ativo',
    ];

    protected $searchFillable = [];

    protected $casts = [
        'fl_ativo' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'ref_usuario');
    }
}
