<?php

namespace Modules\Course\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\Course\Models\Course;

class CourseStudentPolicy {
    use HandlesAuthorization;
    public function viewAny(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)  || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists());
    }
    public function view(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)  || $course->lecturers()->where('lecturer_id', $user->id)->exists();
    }
    public function create(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id);
    }
    public function update(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists());
    }
    public function delete(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id);
    }
}
