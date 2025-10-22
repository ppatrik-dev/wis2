<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public function showRegister() {
        return view('auth::register');
    }
    public function showLogin() {
        return view('auth::login');
    }
    public function register(Request $request) {
        // Registration logic here
    }
    public function login(Request $request) {
        // Login logic here
    }
}
