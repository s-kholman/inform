<?php

namespace App\Http\Controllers\Application;

use App\Models\Application\Application;
use App\Models\Application\ApplicationName;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Util\Exception;

class ApplicationGetActive
{
    public function __invoke(int $user_id, string $factory_name)
    {

        /*
         * Запрос должен быть следующий:
         * Поиск по пользователю, все заявки
         * Исключить, заявки по полю "identification", если есть статус закрытого задания.
         * Статус закрытого задания "application_status_id" = 100
         *
         * */
        try {

            $applicationName = ApplicationName::query()->where('factory_name', $factory_name)->first();

            $application_first = Application::query()
                ->where('user_id', $user_id)
                ->where('application_name_id', $applicationName->id ?? '0')
                ->first();
            if (!empty($application_first) && $application_first->ApplicationStatus->status_code !== 100){

                return Application::query()
                    ->with('ApplicationStatus')
                    ->where('identification', $application_first->identification)
                    ->orderBy('created_at')
                    ->get()
                    //->sortByDesc('created_at')
                    ;
            }
        }catch (Exception $exception){
            return [];
        }

        return null;




    }
}
