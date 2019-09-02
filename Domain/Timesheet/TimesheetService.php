<?php

namespace Domain\Timesheet;

class TimesheetService
{
    protected $repo;

    public function __construct(TimesheetRepository $repo)
    {
        $this->repo = $repo;
    }

    public function buscarTotaisPorTimesheet()
    {
        $horas_periodo_geral = $this->repo->buscarTotalHorasPeriodoGeral();
        $horas_periodo_usuarios = $this->repo->buscarTotalHorasPeriodoUsuarios();
        $horas_periodo_usuario = $this->repo->buscarTotalHorasPeriodoUsuario();

        return compact('horas_periodo_geral', 'horas_periodo_usuarios', 'horas_periodo_usuario');
    }
}
