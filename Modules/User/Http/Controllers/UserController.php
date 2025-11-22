<?php

namespace Modules\User\Http\Controllers;
//
//   @file UserController.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Controller for managing users in the User module
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Log;
use Modules\User\Services\RoleService;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller {

    protected $roleService;

    public function __construct(RoleService $roleService) {
        $this->roleService = $roleService;
    }

    /**
     * Show all users
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {
        $this->authorize('viewAny', User::class);
        $roles = $this->roleService->getAllRoles();

        $perPage = 10;
        $query = $request->input('query', '');
        $role  = $request->input('role', null);

        $usersQuery = User::query()
            ->where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"]);

        $users = $usersQuery->paginate($perPage);

        if (!empty($role)) {
            $filteredUsers = $users->getCollection()->filter(fn($user) => $user->hasRole($role))->values();
            $users->setCollection($filteredUsers);
        }

        return view(
            'user::index',
            ["users" => $users, "roles" => $roles, "query" => $query, "selectedRole" => $role]
        );
    }

    /**
     * Show form to create a new user
     *
     * @return void
     */
    public function create() {
        $this->authorize('create', User::class);
        $roles = $this->roleService->getAllRoles();
        return view('user::create', ['roles' => $roles]);
    }

    /**
     * Create a new user
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request) {
        $this->authorize('create', User::class);
        $validated = $request->validate([
            'degree'      => ['nullable', 'string', 'max:64'],
            'first_name'  => ['required', 'string', 'max:64'],
            'last_name'   => ['required', 'string', 'max:64'],
            'gender'      => ['required', Rule::in(['male', 'female'])],
            'birth_date'  => ['required', 'date'],
            'country'     => ['nullable', 'string', 'max:64'],
            'bio'         => ['nullable', 'string'],
            'email'       => ['required', 'email', 'max:64', 'unique:users,email'],
            'password'    => ['string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($validated);
        $this->roleService->assignRoles($user, $request->input('roles', []));
        return redirect()->route('user.index')->with('success', 'User created successfully !');
    }

    /**
     * Show specific user
     *
     * @param int $id
     * @return void
     */
    public function show($id) {
        $roles = $this->roleService->getAllRoles();
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
        return view('user::show', ["user" => $user, "roles" => $roles]);
    }

    /**
     *
     *
     * @param int $id
     * @return void
     */
    public function edit($id) {
        $roles = $this->roleService->getAllRoles();
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('user::edit', ["user" => $user, "roles" => $roles]);
    }

    /**
     * Update a user
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id) {

        $validated = $request->validate([
            'degree'      => ['nullable', 'string', 'max:64'],
            'first_name'  => ['required', 'string', 'max:64'],
            'last_name'   => ['required', 'string', 'max:64'],
            'gender'      => ['required', Rule::in(['male', 'female'])],
            'birth_date'  => ['required', 'date'],
            'country'     => ['nullable', 'string', 'max:64'],
            'bio'         => ['nullable', 'string'],
            'email'       => ['required', 'email', 'max:64', Rule::unique('users', 'email')->ignore($id)],
            'password'    => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (!$request->filled('password')) {
            unset($validated['password']);
        }

        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $user->update($validated);
        $this->roleService->assignRoles($user, $request->input('roles', []));
        return redirect()->route('user.show', $user->id)->with('success', 'User updated successfully !');
    }

    /**
     * Delete a user
     *
     * @param int $id
     * @return void
     */
    public function destroy($id) {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully!');
    }
}
