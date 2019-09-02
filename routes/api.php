<?php

Route::group(['prefix' => 'v1'], function () {

    Route::post('login', '\Domain\Usuario\UsuarioController@login')->name('login');
    Route::get('logout', '\Domain\Usuario\UsuarioController@logout')->name('logout');

    Route::group(['middleware' => ['jwt.auth', 'valida.token', 'valida.permissao']], function () {

        Route::get('relatorio/tarefas-por-periodo', [
            'uses' => '\Domain\Tarefa\TarefaController@tarefasPorPeriodo',
            'as' => 'relatorio.tarefas-por-periodo'
        ]);

        Route::post('dashboard/totais-por-timesheet', [
            'uses' => '\Domain\Timesheet\TimesheetController@totaisPorTimesheet',
            'as' => 'dashboard.totais-por-timesheet'
        ]);

        Route::get('dashboard/totais-por-situacao', [
            'uses' => '\Domain\TarefaSituacao\TarefaSituacaoController@totaisPorSituacao',
            'as' => 'dashboard.totais-por-situacao'
        ]);

        Route::get('dashboard/totais-por-tipo', [
            'uses' => '\Domain\TarefaTipo\TarefaTipoController@totaisPorTipo',
            'as' => 'dashboard.totais-por-tipo'
        ]);

        Route::post('projeto/reordenar', [
            'uses' => '\Domain\Projeto\ProjetoController@reordenar',
            'as' => 'projeto.reordenar'
        ]);

        Route::post('projeto/{projeto}/atualizar-situacao', [
            'uses' => '\Domain\Projeto\ProjetoController@atualizarSituacao',
            'as' => 'projeto.atualizar-situacao'
        ]);

        Route::post('tarefa/reordenar', [
            'uses' => '\Domain\Tarefa\TarefaController@reordenar',
            'as' => 'tarefa.reordenar'
        ]);

        Route::post('tarefa/{tarefa}/atualizar-situacao', [
            'uses' => '\Domain\Tarefa\TarefaController@atualizarSituacao',
            'as' => 'tarefa.atualizar-situacao'
        ]);

        Route::get('tarefa/{tarefa}/iniciar', ['uses' => '\Domain\Tarefa\TarefaController@iniciar', 'as' => 'tarefa.iniciar']);
        Route::post('tarefa/{tarefa}/pausar', ['uses' => '\Domain\Tarefa\TarefaController@pausar', 'as' => 'tarefa.pausar']);
        Route::get('tarefa/{tarefa}/finalizar', ['uses' => '\Domain\Tarefa\TarefaController@finalizar', 'as' => 'tarefa.finalizar']);
        Route::get('tarefa/{tarefa}/reabrir', ['uses' => '\Domain\Tarefa\TarefaController@reabrir', 'as' => 'tarefa.reabrir']);
        Route::get('tarefa/{tarefa}/duplicar', ['uses' => '\Domain\Tarefa\TarefaController@duplicar', 'as' => 'tarefa.duplicar']);
        Route::get('tarefa/{tarefa}/arquivar', ['uses' => '\Domain\Tarefa\TarefaController@arquivar', 'as' => 'tarefa.arquivar']);

        /*
        |--------------------------------------------------------------------------
        | Cria rotas dos módulos com resource e search dos domínios da aplicação
        |--------------------------------------------------------------------------
        */

        $modules = config('modules');

        foreach ($modules as $module) {
            Route::group(['prefix' => $module['path']], function () use ($module) {
                foreach ($module['domains'] as $domain) {
                    if ($domain['routes']) {
                        // ROTAS DE BUSCA
                        if ($domain['routes'] === 'all' || (is_array($domain['routes']) && in_array('search', $domain['routes']))) {
                            Route::match(
                                ['get', 'post'],
                                $domain['domain'] . '/search',
                                [
                                    'as' => $domain['domain'] . '.search',
                                    'uses' => ($domain['namespace'] ?? $module['namespace']) . '\\' . $domain['name'] . '\\' . $domain['name'] . 'Controller@search'
                                ]
                            );
                        }

                        // ROTAS DOS CRUD'S
                        $routes = ['create', 'edit'];
                        $includeRoutes = false;

                        if ($domain['routes'] !== 'all' && is_array($domain['routes'])) {
                            $includeRoutes = true;
                            $routes = $domain['routes'];
                        }

                        Route::resource(
                            $domain['domain'],
                            ($domain['namespace'] ?? $module['namespace']) . '\\' . $domain['name'] . '\\' . $domain['name'] . 'Controller',
                            [$includeRoutes ? 'only' : 'except' => $routes]
                        );
                    }
                }
            });
        }

    });

});
