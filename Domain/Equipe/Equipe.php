<?php

namespace Domain\Equipe;

use Domain\Base\Models\BaseModel;
use Domain\Tarefa\Tarefa;
use Domain\Usuario\Usuario;

class Equipe extends BaseModel
{
    const CREATED_AT = 'dt_criacao';
    const UPDATED_AT = 'dt_modificacao';

    protected $connection = 'default';
    protected $table = 'equipes';

    protected $fillable = [
        'nome',
        'descricao',
        'email',
        'encarregado',
        'ref_equipe',
    ];

    protected $searchFillable = [
        'id',
        'nome',
        'encarregado',
        'arvore',
        'arvore_humanizada',
    ];

    public function filha()
    {
        return $this->hasMany(Equipe::class, 'ref_equipe');
    }

    public function parente()
    {
        return $this->belongsTo(Equipe::class, 'ref_equipe');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'ref_equipe');
    }

    public function tarefas()
    {
        return $this->belongsToMany(Tarefa::class, 'tarefas_equipes', 'ref_equipe', 'ref_tarefa');
    }

    public function getArvoreAttribute()
    {
        return !empty($this->attributes['arvore']) ? json_decode($this->attributes['arvore']) : [];
    }

    public function setArvoreAttribute($arvore)
    {
        $this->attributes['arvore'] = json_encode($arvore);
    }
}
