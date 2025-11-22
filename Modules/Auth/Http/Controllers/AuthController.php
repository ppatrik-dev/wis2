<?php

namespace Modules\Auth\Http\Controllers;
//
//   @file AuthController.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Controller for user authentication (registration, login, logout)
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller {

    /**
     * Show the registration form.
     *
     * @return void
     */
    public function showRegister() {
        return view('auth::register');
    }
    /**
     * Show the login form.
     *
     * @return void
     */
    public function showLogin() {
        return view('auth::login');
    }
    /**
     *  Handle user registration.
     *
     * @param Request $request request object containing user input
     * @return void
     */
    public function register(Request $request) {
        $validated = $request->validate([
            'degree'      => ['nullable', 'string', 'max:64'],
            'first_name'  => ['required', 'string', 'max:64'],
            'last_name'   => ['required', 'string', 'max:64'],
            'gender'      => ['required', Rule::in(['male', 'female'])],
            'birth_date'  => ['required', 'date'],
            'country'     => ['nullable', 'string', 'max:64'],
            'bio'         => ['nullable', 'string'],
            'email'       => ['required', 'email', 'max:64', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($validated);
        $user->assignRole('user');
        Auth::login($user);
        return redirect()->route('course.index')->with('success', 'User created successfully !');
    }
    /**
     * Handle user login.
     *
     * @param Request $request request object containing user input
     * @return void
     */
    public function login(Request $request) {
        $validated = $request->validate([
            'email'       => ['required', 'email', 'max:64',],
            'password'    => ['required', 'string'],
        ]);
        if (Auth::attempt($validated, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('index');
        }
        throw ValidationException::withMessages((['credentials' => 'The provided credentials do not match our records.']));
    }
    /**
     *  Handle user logout.
     *
     * @param Request $request request object
     * @return void
     */
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('course.index');
    }
}
