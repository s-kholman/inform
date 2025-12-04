<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
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
