<?php

/**
 * @file web.php
 * @author Patrik Procházka (xprochp00@vutbr.cz), Miroslav Basista (xbasim00)
 * @brief Web routes for Term module
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

use Illuminate\Support\Facades\Route;
use Modules\Term\Http\Controllers\TermController;
use Modules\Term\Http\Controllers\TimeTableController;
use Modules\Term\Http\Controllers\RoomController;
use Modules\Term\Http\Controllers\TermStudentController;


Route::middleware('auth')->group(function () {
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
});
