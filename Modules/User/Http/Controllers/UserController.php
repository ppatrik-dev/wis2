<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        try {
            $users = User::orderBy('created_at', 'desc')->paginate(10);
            return view('user::index', ["users" => $users]);
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return back()->withError('Failed to load users.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $validated = $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'sex'        => 'required',
            'birth_date' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create($validated);
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id) {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        $user = User::findOrFail($id);
        return view('user::edit', ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {

        $validated = $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:users,email,' . $id,
            'sex'        => 'required',
            'birth_date' => 'required',
            'password'   => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
