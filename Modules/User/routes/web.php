<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::resource('users', UserController::class)->names('user')->middleware('auth');
