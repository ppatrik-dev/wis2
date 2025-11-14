<?php

use Illuminate\Support\Facades\Route;
use Modules\Term\Http\Controllers\TermController;
use Modules\Term\Http\Controllers\TimeTableController;

Route::resource('terms', TermController::class)->names('term');
Route::get('timetable', [TimetableController::class, 'index'])
    ->name('timetable.index');
