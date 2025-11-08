<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($validated);
        $user->assignRole('user');
        Auth::login($user);
        // $this->roleService->assignRoles($user, $request->input('roles', []));
        return redirect()->route('user.index')->with('success', 'User created successfully !');
    }
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
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('show.login');
        // Logout logic here
    }
}
