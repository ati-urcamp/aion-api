<?php

namespace Domain\UsuarioPerfil;

use Domain\Perfil\Perfil;
use Domain\Usuario\Usuario;
use Domain\Base\Models\BaseModel;

class UsuarioPerfil extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'usuarios_perfis';

    public $timestamps = false;

    protected $fillable = [
        'ref_usuario',
        'ref_perfil',
    ];

    protected $searchFillable = [];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'ref_usuario');
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'ref_perfil');
    }
}
