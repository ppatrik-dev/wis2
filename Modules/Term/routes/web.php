<?php

use Illuminate\Support\Facades\Route;
use Modules\Term\Http\Controllers\TermController;
use Modules\Term\Http\Controllers\TimeTableController;
use Modules\Term\Http\Controllers\RoomController;
use Modules\Term\Http\Controllers\TermStudentController;

Route::resource('terms', TermController::class)->names('term');

Route::prefix('terms/{term}')->group(function () {
    Route::resource('students', TermStudentController::class)
        ->parameters(['students' => 'student'])
        ->names('term.student');
});

Route::resource('rooms', RoomController::class)->names('room');

Route::get('timetable', [TimetableController::class, 'index'])
    ->name('timetable.index');
