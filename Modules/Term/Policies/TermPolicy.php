<?php

namespace Modules\Term\Policies;
//
//   @file TermPolicy.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Policy class for Term model authorization
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Term\Models\Term;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Log;

class TermPolicy {
    use HandlesAuthorization;
    /**
     * View any term
     *
     * @param User $user
     * @return void
     */
    public function viewAny(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor', 'lecturer', 'student', 'user']);
    }
    /**
     * View a specific term
     *
     * @param User $user
     * @param Term $term
     * @return void
     */
    public function view(User $user, Term $term) {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        if ($user->hasRole('lecturer') && $term->lecturer_id === $user->id) {
            return true;
        }
        if ($term->course && ($user->hasRole('student') && $term->course->students()->where('users.id', $user->id)->exists() && $term->course->isStudentApproved($user))) {
            return true;
        }

        return false;
    }
    /**
     * Create a term
     *
     * @param User $user
     * @return void
     */
    public function create(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor']);
    }
    /**
     * Update a term
     *
     * @param User $user
     * @param Term $term
     * @return void
     */
    public function update(User $user, Term $term) {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        return false;
    }
    /**
     * Delete a term
     *
     * @param User $user
     * @param Term $term
     * @return void
     */
    public function delete(User $user, Term $term) {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        return false;
    }
    /**
     * Register for a term
     *
     * @param User $user
     * @param Term $term
     * @return void
     */
    public function register(User $user, Term $term) {
        if ($user->hasRole('student') && $term->course->students()->where('users.id', $user->id)->exists()) {
            return true;
        }
        return false;
    }
}
