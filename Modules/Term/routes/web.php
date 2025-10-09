<?php

use Illuminate\Support\Facades\Route;
use Modules\Term\Http\Controllers\TermController;

Route::resource('terms', TermController::class)->names('term');
