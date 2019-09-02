<?php

namespace Domain\Timesheet;

use Domain\Timesheet\TimesheetRepository as Repository;
use Domain\Base\Controllers\AbstractController;

class TimesheetController extends AbstractController
{
    public function repo()
    {
        return Repository::class;
    }

    public function totaisPorTimesheet(TimesheetService $service)
    {
        return handleResponses($service->buscarTotaisPorTimesheet());
    }
}
