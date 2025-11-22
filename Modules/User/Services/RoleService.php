<?php

namespace Modules\User\Services;
//
//   @file RoleService.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Service class for managing roles in the User module
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Spatie\Permission\Models\Role;
use Modules\User\Models\User;

class RoleService {
    public function getAllRoles() {
        return Role::all();
    }
    public function assignRoles(User $user, array $roles) {
        $user->syncRoles($roles);
    }
    public function assignRole(User $user, string $role) {
        $user->assignRole($role);
    }
}
