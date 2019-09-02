<?php

namespace Domain\Usuario;

use Domain\Base\Models\BaseAuthModel;
use Domain\Equipe\Equipe;
use Domain\Perfil\Perfil;
use Domain\Tarefa\Tarefa;
use Domain\Timesheet\Timesheet;
use Domain\UsuarioHorario\UsuarioHorario;
use Domain\UsuarioToken\UsuarioToken;
use Illuminate\Notifications\Notifiable;

class Usuario extends BaseAuthModel
{
    use Notifiable;

    const CREATED_AT = 'dt_criacao';
    const UPDATED_AT = 'dt_modificacao';

    protected $connection = 'default';
    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
        'login',
        'senha',
        'avatar',
        'fl_ativo',
        'ref_equipe',
        'valor_hora',
    ];

    protected $searchFillable = [
        'nome',
        'fl_ativo',
        'ref_equipe',
    ];

    protected $hidden = [
        'senha',
    ];

    protected $casts = [
        'fl_ativo' => 'boolean',
    ];

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }

    public function tokens()
    {
        return $this->hasMany(UsuarioToken::class, 'ref_usuario');
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'ref_equipe');
    }

    public function horarios()
    {
        return $this->hasMany(UsuarioHorario::class, 'ref_usuario')
            ->orderBy('dia_semana')
            ->orderBy('hora_entrada')
            ->orderBy('hora_saida');
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class, 'ref_usuario');
    }

    public function tarefas()
    {
        return $this->belongsToMany(Tarefa::class, 'tarefas_usuarios', 'ref_usuario', 'ref_tarefa');
    }

    public function tarefas_timesheet()
    {
        return $this->hasMany(Tarefa::class, 'ref_usuario_timesheet');
    }

    public function tarefas_finalizadas()
    {
        return $this->hasMany(Tarefa::class, 'ref_usuario_finalizado');
    }

    public function tarefas_reabertas()
    {
        return $this->hasMany(Tarefa::class, 'ref_usuario_reaberto');
    }

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'usuarios_perfis', 'ref_usuario', 'ref_perfil');
    }
}
