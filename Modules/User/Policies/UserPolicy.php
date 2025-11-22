<?php

namespace Modules\User\Policies;
//
//   @file UserPolicy.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Policy class for User model authorization
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;

class UserPolicy {
    use HandlesAuthorization;
    public function viewAny(User $user) {
        return $user->hasRole('admin');
    }
    public function view(User $user, User $model) {
        return $user->hasRole('admin') || $user->id === $model->id;
    }
    public function create(User $user) {
        return $user->hasRole('admin');
    }
    public function update(User $user, User $model) {
        return $user->hasRole('admin') || $user->id === $model->id;
    }
    public function delete(User $user, User $model) {
        return $user->hasRole('admin') || $user->id === $model->id;
    }
}
