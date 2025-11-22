<?php
//
//   @file web.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Web routes for User module
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::resource('users', UserController::class)->names('user')->middleware('auth');
