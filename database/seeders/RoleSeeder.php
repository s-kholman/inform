<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'PassFilial.user']);
        $permission = Permission::query()
            ->create([
                'name' => $role->name . '.view',
                'guard_name' => 'web'
            ]);
        $role->syncPermissions($permission);

        $role = Role::create(['name' => 'PassFilial.completed']);

        $permission = Permission::query()
            ->create([
                'name' => $role->name . '.create',
                'guard_name' => 'web'
            ]);
        $role->syncPermissions($permission);
    }
}
