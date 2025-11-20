<?php

namespace Modules\Course\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\Course\Models\Course;

class CoursePolicy {
    use HandlesAuthorization;
    public function viewAny(User $user) {
        return $user->hasRole(['admin', 'guarantor', 'lecturer', 'student']);
    }
    public function view(User $user) {
        return $user->hasRole(['admin', 'guarantor', 'lecturer', 'student']);
    }
    public function create(User $user) {
        // All authenticated users can create courses
        return true;
    }
    public function update(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id);
    }
    public function delete(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id);
    }
    public function register(User $user, Course $course) {
        return ($user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id));
    }
}
