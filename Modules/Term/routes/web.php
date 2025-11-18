<?php

use Illuminate\Support\Facades\Route;
use Modules\Term\Http\Controllers\TermController;
use Modules\Term\Http\Controllers\TimeTableController;
use Modules\Term\Http\Controllers\RoomController;
use Modules\Term\Http\Controllers\TermStudentController;

Route::resource('terms', TermController::class)->names('term');

Route::prefix('terms/{term}')->group(function () {
    Route::post('students/register', [TermStudentController::class, 'register'])
        ->name('term.student.register');

    Route::post('students/unregister', [TermStudentController::class, 'unregister'])
        ->name('term.student.unregister');
        
    Route::resource('students', TermStudentController::class)
        ->parameters(['students' => 'student'])
        ->names('term.student');

});

Route::post('/terms/{term}/register', [TermController::class, 'register'])
    ->name('term.register');

Route::resource('rooms', RoomController::class)->names('room');

Route::get('timetable', [TimetableController::class, 'index'])
    ->name('timetable.index');
