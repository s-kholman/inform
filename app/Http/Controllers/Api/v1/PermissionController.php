<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Role $role): PermissionResource
    {
        return new PermissionResource(
            $role->permissions
        );
    }
}
