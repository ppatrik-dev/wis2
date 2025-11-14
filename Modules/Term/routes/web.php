<?php

use Illuminate\Support\Facades\Route;
use Modules\Term\Http\Controllers\TermController;
use Modules\Term\Http\Controllers\TimeTableController;
use Modules\Term\Http\Controllers\RoomController;

Route::resource('terms', TermController::class)->names('term');
Route::resource('rooms', RoomController::class)->names('room');
Route::get('timetable', [TimetableController::class, 'index'])
    ->name('timetable.index');
