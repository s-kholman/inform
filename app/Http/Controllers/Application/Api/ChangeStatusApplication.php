<?php

namespace App\Http\Controllers\Application\Api;

use App\Http\Requests\ChangeStatusApplicationRequest;
use App\Models\Application\Application;

class ChangeStatusApplication
{
    public function __invoke(ChangeStatusApplicationRequest $request)
    {
        Application::query()
            ->create(
                [
                    'user_id' => $request->id,
                    'application_name_id' => $request->applicationNameId,
                    'application_status_id' => $request->applicationStatusId,
                    'identification' => $request->identification,
                ]);

        return ['message' => $request->status_code];
    }
}
