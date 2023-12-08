<?php

namespace App\Policies;

use App\Models\Peat;
use App\Models\User;
use Carbon\Carbon;

class PeatPolicy
{
    public function before(User $user)
    {
        return $user->email == 'sergey@krimm.ru' ? true : false;
    }
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user)
    {
        return isset($user->registration->activation) ? true : false;
    }

    public function viewAdmin(User $user)
    {
        return $user->email == 'sergey@krimm.ru' ? true : false;
    }

    public function create(User $user)
    {
        return isset($user->registration->activation) ? true : false;
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
