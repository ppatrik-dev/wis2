<?php

use Illuminate\Support\Facades\Route;
use Modules\Term\Http\Controllers\TermController;


Route::apiResource('terms', TermController::class)->names('term');
