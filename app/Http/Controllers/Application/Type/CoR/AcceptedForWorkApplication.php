<?php

namespace App\Http\Controllers\Application\Type\CoR;

use App\Http\Controllers\Application\Type\ApplicationTypeInterface;
use App\Models\Application\Application;
use Illuminate\Support\Facades\Log;

class AcceptedForWorkApplication extends AbstractHandler
{

    public function handle(Application $application, ApplicationTypeInterface $applicationType)
    {

        if ($application->ApplicationStatus !== null && $application->ApplicationStatus->status_code == 20) {

            $applicationType->acceptedForWorkApplication();

        }elseif ($this->nextHandler !== null){
            $this->nextHandler->handle($application, $applicationType);
        }
    }
}
