<?php

namespace App\Http\Controllers;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUpdateManualRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    public function rolesUserIndex(): Response
    {
        $users = User::query()
            ->with(['Registration', 'Roles'])
            ->get()
            ->where('Registration.activation', true)
            ->sortBy('Registration.last_name')
            ;

        $roles = Role::query()
           // ->where('name', '<>', 'super-user')
            ->get()
            ->groupBy('id')
            ;

        return response()->view('rolePermissions.role.show_user',
            [
                'users' => $users,
                'roles' => $roles,
            ]
        );
    }

    public function rolesUserStore(RoleUpdateManualRequest $manualRequest): RedirectResponse
    {

        DB::beginTransaction();

        try {

            DB::table('model_has_roles')
                ->where('model_id', $manualRequest['user'])
                ->delete();

            foreach ($manualRequest['role'] as $value) {

                DB::table('model_has_roles')->insert(
                    [
                        'role_id' => $value,
                        'model_type' => 'App\Models\User',
                        'model_id' => $manualRequest['user'],
                    ]
                );
            }

            app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

            DB::commit();

        } catch (QueryException $exception) {

            DB::rollBack();

            return redirect()->route('roles.user.index');

        }

        return redirect()->route('roles.user.index');
    }
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

        foreach ($roleRequest['roles'] as $role) {
            Role::create(
                [
                    'name' => $roleRequest['model'] . '.' . $role,
                    'guard_name' => 'web',
                    'description' => $roleRequest->description,
                ]);
        }

        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     */
    public function showRoles(AcronymFullNameUser $fullNameUser)
    {
        $users = User::query()
            ->with('Registration')
            ->get();

        $roles = Role::query()
            ->get();

        foreach ($users as $user) {

            $getRoleUser = $user->getRoleNames();

            for ($i = 0; $i <= $roles->count() - 1; $i++) {
                $uses[$roles[$i]->name] = false;
            }

            foreach ($getRoleUser as $roleUser) {

                $uses[$roleUser] = true;

            }

            $uses['name'] = $fullNameUser->Acronym($user->Registration);
            $roles_user [$user->id] = $uses;

        }

        return view('rolePermissions.role.show',
            [
                'roles' => $roles,
                'roles_user' => $roles_user,
            ]);

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
    public function updateRoles(RoleUpdateManualRequest $manualRequest)
    {

        DB::beginTransaction();

        try {
            DB::table('model_has_roles')->delete();

            foreach ($manualRequest['role'] as $key => $value) {

                DB::table('model_has_roles')->insert(
                    [
                        'role_id' => Str::of($value)->after('_'),
                        'model_type' => 'App\Models\User',
                        'model_id' => Str::of($value)->before('_')
                    ]
                );
            }

            app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

            DB::commit();

        } catch (QueryException $exception) {

            DB::rollBack();

            return redirect()->route('roles.show.admin');

        }

        return redirect()->route('roles.show.admin');
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

        if (!empty($request->permissions)) {
            $permissions = array_map(function ($arr) use ($role) {
                Permission::query()
                    ->updateOrCreate(
                        [
                            'name' => $role->name . '.' . $arr
                        ],
                        [
                            'guard_name' => 'web'
                        ]
                    );
                return $role->name . '.' . $arr;
            }, $request->permissions);

            $get = Permission::query()
                ->whereIn('name', $permissions)->get();
        } else {
            $get = [];
        }


        $role->syncPermissions($get);

        return redirect()->route('permissions.role.index');
    }
}
