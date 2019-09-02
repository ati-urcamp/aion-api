<?php

namespace Domain\Tarefa;

class TarefaObserver
{
    /**
     * Listen to the User deleting event.
     *
     * @param Tarefa $tarefa
     * @return void
     */
    public function deleting(Tarefa $tarefa)
    {
        $tarefa->timesheets()->delete();
        $tarefa->equipes()->sync([]);
        $tarefa->usuarios()->sync([]);
        $tarefa->checklist()->delete();
    }
}
