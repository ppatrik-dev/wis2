<?php

namespace Modules\User\Policies;

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
}
