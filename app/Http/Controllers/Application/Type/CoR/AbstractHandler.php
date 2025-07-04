<?php

namespace App\Http\Controllers\Application\Type\CoR;

use App\Http\Controllers\Application\Type\ApplicationTypeInterface;
use App\Models\Application\Application;

class AbstractHandler implements HandlerInterface
{

    protected ?HandlerInterface $nextHandler = null;

    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(Application $application, ApplicationTypeInterface $applicationType)
    {
    }
}
