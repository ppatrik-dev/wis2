<?php

namespace Modules\Term\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\Term;
use Modules\User\Models\User;
use Modules\Term\Models\Room;

class RoomPolicy {
    use HandlesAuthorization;
    public function viewAny(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor', 'lecturer', 'student']);
    }
    public function view(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor', 'lecturer', 'student']);
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
