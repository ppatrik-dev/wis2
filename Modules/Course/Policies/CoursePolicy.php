<?php

namespace Modules\Course\Policies;
//
//   @file CoursePolicy.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Policy class for Course model authorization
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\Course\Models\Course;

class CoursePolicy {
    use HandlesAuthorization;
    /**
     * View any course
     *
     * @param User $user
     * @return void
     */
    public function viewAny(User $user) {
        return $user->hasRole(['admin', 'guarantor', 'lecturer', 'student', 'user']);
    }
    /**
     * View specific course
     *
     * @param User $user
     * @return void
     */
    public function view(User $user) {
        return $user->hasRole(['admin', 'guarantor', 'lecturer', 'student', 'user']);
    }
    /**
     * Create a course
     *
     * @param User $user
     * @return void
     */
    public function create(User $user) {
        // All authenticated users can create courses
        return true;
    }
    /**
     * Update a course
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
     * Delete a course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function delete(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id);
    }
    /**
     * Register for a course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function register(User $user, Course $course) {
        return ($user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists()));
    }
    /**
     * View students of a course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function viewStudents(User $user, Course $course) {
        return ($user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists()));
    }
    /**
     * View lecturers of a course
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function viewLecturers(User $user, Course $course) {
        return ($user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id));
    }
    /**
     * View course news
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function viewNews(User $user, Course $course) {
        $isEnrolled = $course->students->contains('id', $user->id) && $course->isStudentApproved($user);
        $isGuarantor = $user->hasRole('guarantor') && $course->guarantor_id === $user->id;
        $isLecturer = $user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists();
        return $isEnrolled || $isGuarantor || $isLecturer || $user->hasRole('admin');
    }
    /**
     * View my courses
     *
     * @param User $user
     * @param Course $course
     * @return void
     */
    public function viewMyCourse(User $user, Course $course) {
        return $course->students->contains('id', $user->id) && $course->isStudentApproved($user);
    }
}
