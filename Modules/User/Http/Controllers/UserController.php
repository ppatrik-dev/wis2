<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Log;
use Modules\User\Services\RoleService;

class UserController extends Controller {

    protected $roleService;

    public function __construct(RoleService $roleService) {
        $this->roleService = $roleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $roles = $this->roleService->getAllRoles();
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('user::index', ["users" => $users, "roles" => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $roles = $this->roleService->getAllRoles();
        return view('user::create', ['roles' => $roles]);
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
            'password' => 'required|string|min:8confirmed',
        ]);

        $user = User::create($validated);
        $this->roleService->assignRole($user, "user");
        return redirect()->route('user.index')->with('success', 'User created successfully !');
    }

    /**
     * Show the specified resource.
     */
    public function show($id) {
        $roles = $this->roleService->getAllRoles();
        $user = User::findOrFail($id);
        return view('user::show', ["user" => $user, "roles" => $roles]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        $roles = $this->roleService->getAllRoles();
        $user = User::findOrFail($id);
        return view('user::edit', ["user" => $user, "roles" => $roles]);
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
            'password'   => 'nullable|string|min:8',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);
        $this->roleService->assignRoles($user, $request->input('roles', []));
        return redirect()->route('user.index')->with('success', 'User updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully!');
    }
}
