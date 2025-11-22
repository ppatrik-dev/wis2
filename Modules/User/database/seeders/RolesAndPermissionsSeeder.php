<?php

namespace Modules\User\database\seeders;

//
//   @file RolesAndPermissionsSeeder.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Seeder to populate roles and permissions for the User module
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = 'web';

        $permissions = config('user.RolesPermissions.permissions', []);
        $roles = config('user.RolesPermissions.roles', []);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => $guard]);
        }

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => $guard]);

            if (in_array('*', $rolePermissions)) {
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions($rolePermissions);
            }
        }
    }
}
