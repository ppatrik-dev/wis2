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
    /**
     * Get all roles for the user
     *
     * @return void
     */
    public function getAllRoles() {
        return Role::all();
    }
    /**
     * Assign more roles to the user
     *
     * @param User $user
     * @param array $roles
     * @return void
     */
    public function assignRoles(User $user, array $roles) {
        $user->syncRoles($roles);
    }
    /**
     * Assign role to the user
     *
     * @param User $user
     * @param string $role
     * @return void
     */
    public function assignRole(User $user, string $role) {
        $user->assignRole($role);
    }
}
