<?php

namespace Modules\Term\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Term\Models\Term;
use Modules\User\Models\User;
use Modules\Term\Models\Room;

class RoomPolicy {
    use HandlesAuthorization;
    public function viewAny(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor', 'lecturer', 'student', 'user']);
    }
    public function view(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor', 'lecturer', 'student', 'user']);
    }
    public function create(User $user) {
        return $user->hasRole('admin');
    }
    public function update(User $user) {
        return $user->hasRole('admin');
    }
    public function delete(User $user) {
        return $user->hasRole('admin');
    }
}
