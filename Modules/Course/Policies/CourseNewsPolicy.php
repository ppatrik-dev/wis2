<?php

namespace Modules\Course\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\Course\Models\CourseNews;
use Modules\Course\Models\Course;

class CourseNewsPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists())
            || ($course->students()->where('student_id', $user->id)->exists() && $course->isStudentApproved($user));
    }

    public function view(User $user, CourseNews $news) {
        $course = $news->course;

        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists())
            || ($course->students()->where('student_id', $user->id)->exists() && $course->isStudentApproved($user));
    }

    public function create(User $user, Course $course) {
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists());
    }

    public function update(User $user, CourseNews $news) {
        $course = $news->course;
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists());
    }

    public function delete(User $user, CourseNews $news) {
        $course = $news->course;
        return $user->hasRole('admin')
            || ($user->hasRole('guarantor') && $course->guarantor_id === $user->id)
            || ($user->hasRole('lecturer') && $course->lecturers()->where('lecturer_id', $user->id)->exists());
    }
}
