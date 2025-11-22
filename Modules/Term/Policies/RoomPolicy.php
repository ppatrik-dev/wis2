<?php

namespace Modules\Term\Policies;
//
//   @file RoomPolicy.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Policy class for Room model authorization
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Term\Models\Term;
use Modules\User\Models\User;
use Modules\Term\Models\Room;

class RoomPolicy {
    use HandlesAuthorization;
    /**
     * View any rooms
     *
     * @param User $user
     * @return void
     */
    public function viewAny(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor', 'lecturer', 'student', 'user']);
    }
    /**
     * View a specific room
     *
     * @param User $user
     * @return void
     */
    public function view(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor', 'lecturer', 'student', 'user']);
    }
    /**
     * Create a room
     *
     * @param User $user
     * @return void
     */
    public function create(User $user) {
        return $user->hasRole('admin');
    }
    /**
     * Update a room
     *
     * @param User $user
     * @return void
     */
    public function update(User $user) {
        return $user->hasRole('admin');
    }
    /**
     * Delete a room
     *
     * @param User $user
     * @return void
     */
    public function delete(User $user) {
        return $user->hasRole('admin');
    }
}
