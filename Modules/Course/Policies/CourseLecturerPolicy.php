<?php

namespace Modules\Course\Policies;
//
//   @file CourseLecturerPolicy.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Policy class for CourseLecturer model authorization
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\Course\Models\Course;

class CourseLecturerPolicy {
    use HandlesAuthorization;
    /**
     * Show lecturers of a course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function viewAny(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id);
    }
    /**
     * Show a specific lecturer of a course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function view(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id);
    }
    /**
     * Add a lecturer to a course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function create(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id);
    }
    /**
     * Update a lecturer of a course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function update(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id);
    }
    /**
     * Remove a lecturer from a course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function delete(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id);
    }
}
