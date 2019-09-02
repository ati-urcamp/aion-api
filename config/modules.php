<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Módulos da aplicação
    |--------------------------------------------------------------------------
    */

    [
        'name' => '',
        'path' => '',
        'namespace' => '\\Domain',
        'domains' => [
            ['domain' => 'cliente', 'name' => 'Cliente', 'realName' => 'Clientes', 'routes' => 'all'],
            ['domain' => 'configuracao', 'name' => 'Configuracao', 'realName' => 'Configurações', 'routes' => 'all'],
            ['domain' => 'equipe', 'name' => 'Equipe', 'realName' => 'Equipes', 'routes' => 'all'],
            ['domain' => 'perfil', 'name' => 'Perfil', 'realName' => 'Perfis', 'routes' => 'all'],
            ['domain' => 'perfil-permissao', 'name' => 'PerfilPermissao', 'realName' => 'Permissões dos Perfis', 'routes' => false],
            ['domain' => 'permissao', 'name' => 'Permissao', 'realName' => 'Permissões', 'routes' => 'all'],
            ['domain' => 'projeto', 'name' => 'Projeto', 'realName' => 'Projetos', 'routes' => 'all'],
            ['domain' => 'projeto-situacao', 'name' => 'ProjetoSituacao', 'realName' => 'Situações dos Projetos', 'routes' => 'all'],
            ['domain' => 'projeto-tipo', 'name' => 'ProjetoTipo', 'realName' => 'Tipos dos Projetos', 'routes' => 'all'],
            ['domain' => 'tarefa', 'name' => 'Tarefa', 'realName' => 'Tarefas', 'routes' => 'all'],
            ['domain' => 'tarefa-equipe', 'name' => 'TarefaEquipe', 'realName' => 'Equipes das Tarefas', 'routes' => false],
            ['domain' => 'tarefa-situacao', 'name' => 'TarefaSituacao', 'realName' => 'Situações das Tarefas', 'routes' => 'all'],
            ['domain' => 'tarefa-tipo', 'name' => 'TarefaTipo', 'realName' => 'Tipos das Tarefas', 'routes' => 'all'],
            ['domain' => 'tarefa-usuario', 'name' => 'TarefaUsuario', 'realName' => 'Usuários das Tarefas', 'routes' => false],
            ['domain' => 'tarefa-checklist', 'name' => 'TarefaChecklist', 'realName' => 'Checklist das Tarefas', 'routes' => 'all'],
            ['domain' => 'timesheet', 'name' => 'Timesheet', 'realName' => 'Timesheets', 'routes' => false],
            ['domain' => 'usuario', 'name' => 'Usuario', 'realName' => 'Usuários', 'routes' => 'all'],
            ['domain' => 'usuario-horario', 'name' => 'UsuarioHorario', 'realName' => 'Horários dos Usuários', 'routes' => false],
            ['domain' => 'usuario-perfil', 'name' => 'UsuarioPerfil', 'realName' => 'Perfis dos Usuários', 'routes' => false],
            ['domain' => 'usuario-token', 'name' => 'UsuarioToken', 'realName' => 'Tokens dos Usuários', 'routes' => false],
        ],
    ],

];
