<?php

namespace App\Http\Controllers\Application\Type\CoR;

use App\Http\Controllers\Application\Type\ApplicationTypeInterface;
use App\Models\Application\Application;

class RejectionApplication extends AbstractHandler
{

    public function handle(Application $application, ApplicationTypeInterface $applicationType)
    {
        if ($application->ApplicationStatus !== null && $application->ApplicationStatus->status_code == 30) {
            $applicationType->rejectionApplication();
        }elseif ($this->nextHandler !== null){
            $this->nextHandler->handle($application, $applicationType);
        }
    }
}
