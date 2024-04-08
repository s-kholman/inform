<?php

namespace App\Policies;

use App\Actions\registration\RegistrationCheckAction;
use App\Models\Peat;
use App\Models\User;
use Carbon\Carbon;

class PeatPolicy
{
    private  RegistrationCheckAction $registrationCheckAction;

    public function __construct()
    {
        $this->registrationCheckAction = new RegistrationCheckAction;
    }

    public function view(User $user)
    {
        return $this->registrationCheckAction->check($user);
    }

    public function viewAdmin(User $user)
    {
        return $user->email == 'sergey@krimm.ru' ? true : false;
    }

    public function create(User $user)
    {
        return $this->registrationCheckAction->check($user);
    }

    public function delete(User $user, Peat $peat)
    {
        $createdMinutes = Carbon::now()->diffInMinutes($peat->created_at);
        if (($createdMinutes <= 60 && $user->Registration->filial_id == $peat->filial_id)){
            return true;
        }
        return false;
    }
}
