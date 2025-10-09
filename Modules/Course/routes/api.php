<?php

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\CourseController;


Route::apiResource('courses', CourseController::class)->names('course');
