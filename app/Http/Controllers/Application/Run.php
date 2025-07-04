<?php

namespace App\Http\Controllers\Application;

use App\Models\Application\Application;

class Run
{
    public function run()
    {
            $run = new ApplicationRun();
           $run(Application::query()->with('ApplicationName')->find(28));

   }
}
