<?php

namespace Modules\Course\Policies;
//
//   @file CourseStudentPolicy.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Policy class for CourseStudent model authorization
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\Course\Models\Course;

class CourseStudentPolicy {
    use HandlesAuthorization;
    /**
     * View students of the course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function viewAny(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)  || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists());
    }
    /**
     * View specific student of the course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function view(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)  || $course->lecturers()->where('lecturer_id', $user->id)->exists();
    }
    /**
     * CAdd a student to the course
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
     * Update a student of the course
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
     * Remove student from the course
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
