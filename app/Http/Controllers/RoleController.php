<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\PermissionName;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = ['user' => 'пользователь', 'completed' => 'исполнитель', 'director' => 'директор', 'deploy' => 'зам. ген. дир.', 'combining' => 'совместитель'];

        return view('rolePermissions.role.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $roleRequest)
    {

        foreach ($roleRequest['roles'] as $role){
            Role::create(['name' => $roleRequest['model'] . '.' .$role]);
        }

//        foreach (PermissionName::all() as $permission){
//            Permission::create([
//                'name' => $request->role . '.' . $permission->name
//            ]);
//        }

        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function permissions()
    {
        return view('rolePermissions.permissions.index');
    }

    public function permissionsAdd(Request $request)
    {
        $role = Role::query()->where('id', $request->role)->first();

        if (!empty($request->permissions)){
            $permissions = array_map(function ($arr) use($role) {
                Permission::query()
                    ->updateOrCreate(
                        [
                            'name' => $role->name . '.'.$arr
                        ],
                        [
                            'guard_name' => 'web'
                        ]
                    );
                return $role->name . '.'.$arr;
            },$request->permissions);

            $get = Permission::query()
                ->whereIn('name', $permissions)->get();
        } else{
            $get = [];
        }


        $role->syncPermissions($get);

        return redirect()->route('permissions.role.index');
    }
}
