<?php

namespace App\Http\Controllers\Application\Type\CoR;

use App\Http\Controllers\Application\Type\ApplicationTypeInterface;
use App\Models\Application\Application;

class CompletedApplication extends AbstractHandler
{
    public function handle(Application $application, ApplicationTypeInterface $applicationType)
    {
        if ($application->ApplicationStatus !== null && $application->ApplicationStatus->status_code == 40) {
            $applicationType->completedApplication();
        }elseif ($this->nextHandler !== null){
            $this->nextHandler->handle($application, $applicationType);
        }
    }
}
