<?php

namespace App\Policies;

use App\Models\ProductMonitoring;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class ProductMonitoringPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductMonitoring $productMonitoring): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->Registration->activation ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductMonitoring $monitoring): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($monitoring->created_at);
        if ((($user->Registration->activation ?? false) && $createdMinutes <= 60*26 && $user->Registration->filial_id == $monitoring->storageName->filial_id) || ($user->email == 'sergey@krimm.ru')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductMonitoring $monitoring): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($monitoring->created_at);
        if (($createdMinutes <= 60 && $user->Registration->filial_id == $monitoring->storageName->filial_id) || ($user->email == 'sergey@krimm.ru')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductMonitoring $productMonitoring): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductMonitoring $productMonitoring): bool
    {
        return true;
    }
}
