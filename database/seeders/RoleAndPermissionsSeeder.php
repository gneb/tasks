<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Enums\UserRolesEnum;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'get-users']);
        Permission::create(['name' => 'update-users']);
        Permission::create(['name' => 'delete-users']);
        Permission::create(['name' => 'get-tasks']);
        Permission::create(['name' => 'create-tasks']);
        Permission::create(['name' => 'update-tasks']);
        Permission::create(['name' => 'delete-tasks']);

        $adminRole = Role::create(['name' => UserRolesEnum::ADMIN->value]);
        $userRole = Role::create(['name' => UserRolesEnum::USER->value]);
        $moderatorRole = Role::create(['name' => UserRolesEnum::MODERATOR->value]);

        $adminRole->givePermissionTo([
            'get-users',
            'update-users',
            'delete-users',
            'get-tasks',
            'create-tasks',
            'update-tasks',
            'delete-tasks',
        ]);

        $moderatorRole->givePermissionTo([
            'get-users',
            'get-tasks',
            'create-tasks',
            'update-tasks',
            'delete-tasks',
        ]);

        $userRole->givePermissionTo([
            'get-tasks'
        ]);

    }
}
