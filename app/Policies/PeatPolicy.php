<?php

namespace App\Policies;

use App\Models\Peat;
use App\Models\User;
use Carbon\Carbon;

class PeatPolicy
{

    public function view(User $user): bool
    {
        return $user->can('Peat.user.view');
    }

    public function viewAdmin(User $user): bool
    {
        return $user->can('super-user.moonlighter');
    }

    public function create(User $user): bool
    {
        return $user->can('Peat.completed.create');
    }

    public function store(User $user): bool
    {
        return $user->can('Peat.completed.store');
    }

    public function delete(User $user, Peat $peat): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($peat->created_at);
        if (($createdMinutes <= 60 && $user->Registration->filial_id == $peat->filial_id)){
            return $user->can('Peat.completed.delete');
        }
        return false;
    }
}
