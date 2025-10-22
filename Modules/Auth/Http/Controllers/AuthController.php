<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function showRegister() {
        return view('auth::register');
    }
    public function showLogin() {
        return view('auth::login');
    }
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
            'password'    => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($validated);
        $user->assignRole('user');
        Auth::login($user);
        // $this->roleService->assignRoles($user, $request->input('roles', []));
        return redirect()->route('user.index')->with('success', 'User created successfully !');
    }
    public function login(Request $request) {
        // Login logic here
    }
}
