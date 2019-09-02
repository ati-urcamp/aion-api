<?php

namespace Domain\Usuario;

class UsuarioObserver
{
    /**
     * Listen to the User deleting event.
     *
     * @param Usuario $usuario
     * @return void
     */
    public function deleting(Usuario $usuario)
    {
        $usuario->tarefas_timesheet()->each(function ($tarefa) {
            $tarefa->ref_usuario_timesheet = null;
            $tarefa->save();
        });

        $usuario->tarefas_finalizadas()->each(function ($tarefa) {
            $tarefa->ref_usuario_finalizado = null;
            $tarefa->save();
        });

        $usuario->tarefas_reabertas()->each(function ($tarefa) {
            $tarefa->ref_usuario_reaberto = null;
            $tarefa->save();
        });

        $usuario->tokens()->delete();
        $usuario->horarios()->delete();
        $usuario->timesheets()->delete();
        $usuario->tarefas()->sync([]);
        $usuario->perfis()->sync([]);
    }
}
