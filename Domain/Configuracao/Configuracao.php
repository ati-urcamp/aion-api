<?php

namespace Domain\Configuracao;

use Domain\Base\Models\BaseModel;

class Configuracao extends BaseModel
{
    protected $connection = 'default';
    protected $table = 'configuracoes';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'valor',
    ];

    protected $searchFillable = [
        'nome',
    ];
}
