<?php

namespace App\Http\Controllers\Application\Type;

interface ApplicationTypeInterface
{
    public function createApplication():void;
    public function acceptedForWorkApplication():void;
    public function rejectionApplication():void;
    public function completedApplication():void;
    public function closedApplication():void;
}
