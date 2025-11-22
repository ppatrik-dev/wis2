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
    public function viewAny(User $user) {
        return $user->hasRole(['admin', 'guarantor', 'lecturer', 'student', 'user']);
    }
    public function view(User $user) {
        return $user->hasRole(['admin', 'guarantor', 'lecturer', 'student', 'user']);
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
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists()));
    }
    public function viewStudents(User $user, Course $course) {
        return ($user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists()));
    }
    public function viewLecturers(User $user, Course $course) {
        return ($user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id));
    }
    public function viewNews(User $user, Course $course) {
        $isEnrolled = $course->students->contains('id', $user->id) && $course->isStudentApproved($user);
        $isGuarantor = $user->hasRole('guarantor') && $course->guarantor_id === $user->id;
        $isLecturer = $user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists();
        return $isEnrolled || $isGuarantor || $isLecturer || $user->hasRole('admin');
    }
    public function viewMyCourse(User $user, Course $course) {
        return $course->students->contains('id', $user->id) && $course->isStudentApproved($user);
    }
}
