<?php

namespace Modules\Term\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Term\Models\Term;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Log;

class TermPolicy {
    use HandlesAuthorization;
    public function viewAny(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor', 'lecturer', 'student', 'user']);
    }
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
    public function create(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor']);
    }
    public function update(User $user, Term $term) {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        return false;
    }
    public function delete(User $user, Term $term) {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        return false;
    }

    public function register(User $user, Term $term) {
        if ($user->hasRole('student') && $term->course->students()->where('users.id', $user->id)->exists()) {
            return true;
        }
        return false;
    }
}
