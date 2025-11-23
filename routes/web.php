<?php
//
//   @file web.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Main routes
//   @version 0.1
//   @date 2025-11-23
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('course.my-courses')
        : redirect()->route('course.index');
})->name('index');
