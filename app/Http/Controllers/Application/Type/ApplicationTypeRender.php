<?php

namespace App\Http\Controllers\Application\Type;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Http\Controllers\Application\Type\CoR\CompletedApplication;
use App\Http\Controllers\Application\Type\CoR\CreateApplication;
use App\Http\Controllers\Application\Type\CoR\ClosedApplication;
use App\Http\Controllers\Application\Type\CoR\AcceptedForWorkApplication;
use App\Http\Controllers\Application\Type\CoR\FinalApplication;
use App\Http\Controllers\Application\Type\CoR\RejectionApplication;
use App\Models\Application\Application;
use App\Models\User;

abstract class ApplicationTypeRender
{

    protected Application $modelApplication;

    function render(Application $application)
    {
        $this->modelApplication = $application;

        $createApplication = new CreateApplication();

        $createApplication
            ->setNext(new AcceptedForWorkApplication())
            ->setNext(new RejectionApplication())
            ->setNext(new ClosedApplication())
            ->setNext(new CompletedApplication())
            ->setNext(new FinalApplication())
        ;
        //dd($application);
        $createApplication->handle($this->modelApplication, $this->run());

    }

    protected function getAuthorApplication(): array
    {
        $acronym = new AcronymFullNameUser;

        $user = User::query()
            ->with('Registration')
            ->find
            (
                Application::query()
                    ->where('identification', $this->modelApplication->identification)
                    ->orderBy('created_at')
                    ->first()->user_id
            );


        return
            [
                'name' => $acronym->Acronym($user->Registration),
                'email' => $user->email
            ];

    }

    protected function getStatusClose()
    {
        return Application::query()
            ->select('name')
            ->leftJoin('application_statuses', 'applications.application_status_id', '=', 'application_statuses.id')
            ->where('identification', $this->modelApplication->identification)
            ->where('status_code', '<>', 100)
            ->orderBy('applications.created_at', 'desc')
            ->first()->name;
    }

    abstract function run(): ApplicationTypeInterface;

}
