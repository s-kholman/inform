<?php

namespace App\Http\Controllers\Application\Type\CoR;

use App\Http\Controllers\Application\Type\ApplicationTypeInterface;
use App\Models\Application\Application;
use Illuminate\Support\Facades\Log;

class FinalApplication extends AbstractHandler
{
    public function handle(Application $application, ApplicationTypeInterface $applicationType)
    {
        Log::info('Final');
        return null;
    }
}
