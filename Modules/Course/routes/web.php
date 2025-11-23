<?php
/**
 * @file web.php
 * @author Nataliia Solomatina (xsolom02)
 * @brief Web routes for Course module
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

use Illuminate\Support\Facades\Route;
use Modules\Course\App\Http\Controllers\CourseController;
use Modules\Course\App\Http\Controllers\CourseLecturerController;
use Modules\Course\App\Http\Controllers\CourseNewsController;
use Modules\Course\App\Http\Controllers\CourseStudentController;
use Modules\Course\App\Http\Controllers\MyCourseController;

Route::resource('courses', CourseController::class)->names('course');
Route::get('my-courses', [MyCourseController::class, 'index'])->name('course.my-courses')->middleware('auth');
Route::patch('courses/{course}/approve', [CourseController::class, 'approve'])->name('course.approve')->middleware('auth');

Route::get('courses/{course}/students/lookup', [CourseStudentController::class, 'lookupPublic'])
    ->name('course.student.lookup')->middleware('auth');

// Bulk register/unregister for the currently authenticated user (from course listing)
Route::post('courses/students/register-multiple', [CourseStudentController::class, 'registerMultiple'])
    ->name('course.student.register-multiple')->middleware('auth');
Route::post('courses/students/unregister-multiple', [CourseStudentController::class, 'unregisterMultiple'])
    ->name('course.student.unregister-multiple')->middleware('auth');
// Single endpoint to update registration states for multiple courses (0 = unregister, 1 = register)
Route::post('courses/students/update-registrations', [CourseStudentController::class, 'updateRegistrations'])
    ->name('course.student.update-registrations')->middleware('auth');

Route::prefix('courses/{course}')->group(function () {
    // Course lecturers
    Route::resource('lecturers', CourseLecturerController::class)->names('course.lecturer')->middleware('auth');

    // Course news
    Route::resource('news', CourseNewsController::class)->names('course.news')->middleware('auth');
    Route::get('news/search', [CourseNewsController::class, 'search'])->name('course.news.search')->middleware('auth');

    // Course students
    Route::resource('students', CourseStudentController::class)->names('course.student');
    Route::get('students/approved', [CourseStudentController::class, 'approved'])->name('course.student.approved')->middleware('auth');
    Route::get('students/pending', [CourseStudentController::class, 'pending'])->name('course.student.pending')->middleware('auth');
    Route::get('students/scores', [CourseStudentController::class, 'scores'])->name('course.student.scores')->middleware('auth');
    Route::post('students/bulk-approve', [CourseStudentController::class, 'bulkApprove'])->name('course.student.bulk-approve')->middleware('auth');
    Route::post('students/bulk-reject', [CourseStudentController::class, 'bulkReject'])->name('course.student.bulk-reject')->middleware('auth');
    Route::patch('students/{student}/approve', [CourseStudentController::class, 'approve'])->name('course.student.approve')->middleware('auth');
    Route::patch('students/{student}/reject', [CourseStudentController::class, 'reject'])->name('course.student.reject')->middleware('auth');
    Route::patch('students/{student}/score', [CourseStudentController::class, 'updateScore'])->name('course.student.update-score')->middleware('auth');
    // Register current authenticated user for this course (checkbox + submit flow)
    Route::post('students/register', [CourseStudentController::class, 'registerCurrentUser'])->name('course.student.register')->middleware('auth');
    Route::post('students/unregister', [CourseStudentController::class, 'unregisterCurrentUser'])->name('course.student.unregister')->middleware('auth');
});
