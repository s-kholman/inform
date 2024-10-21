<?php

namespace Database\Seeders;

use App\Models\PermissionName;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SetRoleSuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'sergey@krimm.ru')->first();
        Role::create(
            [
                'name' => 'super-user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        $user->assignRole('super-user');


        PermissionName::query()
            ->create([
                'name' => 'view',
                'translate_ru' => 'Просмотр',
            ]);
        PermissionName::query()
            ->create([
                'name' => 'store',
                'translate_ru' => 'Сохранить',
            ]);
        PermissionName::query()
            ->create([
                'name' => 'create',
                'translate_ru' => 'Создать',
            ]);
        PermissionName::query()
            ->create([
                'name' => 'delete',
                'translate_ru' => 'Удалить',
            ]);
        PermissionName::query()
            ->create([
                'name' => 'moonlighter',
                'translate_ru' => 'Совмещение',
            ]);
    }
}
