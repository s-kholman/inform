<?php

namespace App\Http\Controllers\Application;


use App\Http\Controllers\Application\Type\ApplicationTypeInterface;
use App\Http\Controllers\Application\Type\ApplicationTypeRender;
use App\Models\Application\Application;
use PHPUnit\Util\Exception;

class ApplicationRun
{
    public function __invoke(Application $application)
    {
        $name_class = '\App\Http\Controllers\Application\Type\\' .$application->ApplicationName->factory_name;
        if (class_exists($name_class)) {
            $class = new $name_class();
            if ($class instanceof ApplicationTypeRender){
               return $class->render($application);
            }
        }
        return false;
    }
}
