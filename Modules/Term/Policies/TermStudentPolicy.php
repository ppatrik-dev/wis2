<?php

namespace Modules\Term\Policies;
//
//   @file  TermStudentPolicy.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief  Policy class for TermStudent model authorization
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Term\Models\Term;
use Modules\Term\Models\TermStudent;
use Modules\User\Models\User;

class TermStudentPolicy {
    use HandlesAuthorization;
    public function viewAny(User $user, Term $term) {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        if ($user->hasRole('lecturer') && $term->lecturer_id === $user->id) {
            return true;
        }
        return false;
    }
    public function view(User $user, TermStudent $student) {
        $term = $student->term;
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        if ($user->hasRole('lecturer') && $term->lecturer_id === $user->id) {
            return true;
        }
        return false;
    }
    public function create(User $user, Term $term) {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        return false;
    }
    public function update(User $user, TermStudent $student) {
        $term = $student->term;
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        if ($user->hasRole('lecturer') && $term->lecturer_id === $user->id) {
            return true;
        }
        return false;
    }
    public function delete(User $user, TermStudent $student) {
        $term = $student->term;
        if ($term->course && ($user->hasRole('guarantor') && $term->course->guarantor_id === $user->id)) {
            return true;
        }
        return false;
    }
}
