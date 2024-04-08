<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;

class AdministratorPolicy
{
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return 'sergey@krimm.ru' === $user->email;
    }

    public function viewMenu(User $user): bool
    {
        return 'sergey@krimm.ru' === $user->email;
    }

    public function destroy (User $user):bool
    {
        return 'sergey@krimm.ru' === $user->email;
    }

    /**
     * @return bool
     * Закрыть временно доступ
     */
    public function showMenu ():bool
    {
        return false;
    }


}
