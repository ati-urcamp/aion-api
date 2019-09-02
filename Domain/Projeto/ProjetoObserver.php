<?php

namespace Domain\Projeto;

class ProjetoObserver
{
    /**
     * Listen to the User deleting event.
     *
     * @param Projeto $projeto
     * @return void
     */
    public function deleting(Projeto $projeto)
    {
        $projeto->tarefas()->each(function ($tarefa) {
            $tarefa->timesheets()->delete();
            $tarefa->equipes()->sync([]);
            $tarefa->usuarios()->sync([]);
            $tarefa->checklist()->delete();
        });

        $projeto->tarefas()->delete();
    }
}
