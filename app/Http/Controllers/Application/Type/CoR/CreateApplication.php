<?php

namespace App\Http\Controllers\Application\Type\CoR;

use App\Http\Controllers\Application\Type\ApplicationTypeInterface;
use App\Models\Application\Application;
use Illuminate\Support\Facades\Log;

class CreateApplication extends AbstractHandler
{

    public function handle(Application $application, ApplicationTypeInterface $applicationType)
    {

        if ($application->ApplicationStatus->status_code == 10) {
            $applicationType->createApplication();
        } elseif ($this->nextHandler !== null){
            $this->nextHandler->handle($application, $applicationType);
        }
    }
}
