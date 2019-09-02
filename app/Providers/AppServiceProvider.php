<?php

namespace App\Providers;

use Domain\Projeto\Projeto;
use Domain\Projeto\ProjetoObserver;
use Domain\Tarefa\Tarefa;
use Domain\Tarefa\TarefaObserver;
use Domain\Usuario\Usuario;
use Domain\Usuario\UsuarioObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Usuario::observe(UsuarioObserver::class);
        Projeto::observe(ProjetoObserver::class);
        Tarefa::observe(TarefaObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
