<?php

namespace Modules\User\Services;

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
