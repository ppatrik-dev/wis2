<?php

namespace Modules\Course\Policies;
//
//   @file CourseNewsPolicy.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Policy class for CourseNews model authorization
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\Course\Models\CourseNews;
use Modules\Course\Models\Course;

class CourseNewsPolicy {
    use HandlesAuthorization;
    /**
     * View any course news
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function viewAny(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists())
            || ($course->students()->where('student_id', $user->id)->exists() && $course->isStudentApproved($user));
    }
    /**
     * View specific course news
     *
     * @param User $user
     * @param CourseNews $news
     * @return void
     */
    public function view(User $user, CourseNews $news) {
        $course = $news->course;

        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists())
            || ($course->students()->where('student_id', $user->id)->exists() && $course->isStudentApproved($user));
    }
    /**
     * Create course news
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function create(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists());
    }
    /**
     * Update course news
     *
     * @param User $user
     * @param CourseNews $news
     * @return void
     */
    public function update(User $user, CourseNews $news) {
        $course = $news->course;
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists());
    }
    /**
     * Delete course news
     *
     * @param User $user
     * @param CourseNews $news
     * @return void
     */
    public function delete(User $user, CourseNews $news) {
        $course = $news->course;
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists());
    }
}
