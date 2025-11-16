<?php

namespace Modules\Term\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Term\Models\Term;
use Modules\User\Models\User;

class TermPolicy {
    use HandlesAuthorization;
    public function viewAny(User $user) {
        return $user->hasAnyRole(['admin', 'guarantor', 'lecturer', 'student']);
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
        if ($user->hasRole('student') && $term->students()->where('users.id', $user->id)->exists()) {
            return true;
        }

        return false;
    }
    public function register(User $user, Term $term) {
        if ($user->hasRole('student') && $term->students()->where('users.id', $user->id)->exists()) {
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
}
