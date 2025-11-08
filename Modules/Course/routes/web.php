<?php

use Illuminate\Support\Facades\Route;
use Modules\Course\App\Http\Controllers\CourseController;
use Modules\Course\App\Http\Controllers\CourseLecturerController;
use Modules\Course\App\Http\Controllers\CourseNewsController;
use Modules\Course\App\Http\Controllers\CourseStudentController;

Route::resource('courses', CourseController::class)->names('course');

Route::get('courses/{course}/students/lookup', [CourseStudentController::class, 'lookupPublic'])
    ->name('course.student.lookup');

Route::prefix('courses/{course}')->group(function () {
    // Course lecturers
    Route::resource('lecturers', CourseLecturerController::class)->names('course.lecturer');

    // Course news
    Route::resource('news', CourseNewsController::class)->names('course.news');
    Route::get('news/search', [CourseNewsController::class, 'search'])->name('course.news.search');

    // Course students
    Route::resource('students', CourseStudentController::class)->names('course.student');
    Route::get('students/approved', [CourseStudentController::class, 'approved'])->name('course.student.approved');
    Route::get('students/pending', [CourseStudentController::class, 'pending'])->name('course.student.pending');
    Route::get('students/scores', [CourseStudentController::class, 'scores'])->name('course.student.scores');
    Route::post('students/bulk-approve', [CourseStudentController::class, 'bulkApprove'])->name('course.student.bulk-approve');
    Route::post('students/bulk-reject', [CourseStudentController::class, 'bulkReject'])->name('course.student.bulk-reject');
    Route::patch('students/{student}/approve', [CourseStudentController::class, 'approve'])->name('course.student.approve');
    Route::patch('students/{student}/reject', [CourseStudentController::class, 'reject'])->name('course.student.reject');
    Route::patch('students/{student}/score', [CourseStudentController::class, 'updateScore'])->name('course.student.update-score');
});

